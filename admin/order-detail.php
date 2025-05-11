<?php
ob_start();
include("../admin/includes/header.php");

// Hàm lấy tên địa phương từ API
function fetchAddressName($type, $id, $districtId = null)
{
    if ($type === 'w') {
        // Lấy danh sách wards từ quận
        if (!$districtId)
            return null;
        $url = "https://provinces.open-api.vn/api/d/$districtId?depth=2";
        $data = @file_get_contents($url);
        if ($data === false)
            return null;
        $json = json_decode($data, true);
        if (!isset($json['wards']))
            return null;

        foreach ($json['wards'] as $ward) {
            if ($ward['code'] == $id) {
                return $ward['name'];
            }
        }
        return null;
    } else {
        $url = "https://provinces.open-api.vn/api/$type/$id";
        $data = @file_get_contents($url);
        if ($data === false)
            return null;
        $json = json_decode($data, true);
        return $json['name'] ?? null;
    }
}


// Kiểm tra orderId
if (!isset($_GET['orderId']) || !is_numeric($_GET['orderId'])) {
    echo "ID đơn hàng không hợp lệ.";
    exit();
}

$orderId = (int) $_GET['orderId'];

// Lấy thông tin địa chỉ đơn hàng
$addressQuery = "SELECT orderAddress, orderCity, orderDistrict, orderWard FROM orders WHERE orderId = ?";
$stmt = $conn->prepare($addressQuery);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $addressResult = $result->fetch_assoc();
} else {
    echo "Không tìm thấy đơn hàng.";
    exit();
}

// Sau khi có dữ liệu, gọi API lấy tên địa phương
$cityName = $addressResult['orderCity'] ? fetchAddressName('p', $addressResult['orderCity']) : '[Không tải được tỉnh/thành]';
$districtName = $addressResult['orderDistrict'] ? fetchAddressName('d', $addressResult['orderDistrict']) : '[Không tải được quận/huyện]';
$wardName = $addressResult['orderWard'] ? fetchAddressName('w', $addressResult['orderWard'], $addressResult['orderDistrict']) : '[Không tải được phường/xã]';

// Lấy chi tiết đơn hàng
function getOrderDetail($orderId)
{
    global $conn;
    $query = "
        SELECT 
            od.orderDetailQuantity AS quantity,
            od.orderDetailPrice AS price,
            p.productName AS product_name,
            pv.productVariantImage AS image,
            o.discountId AS discount_id,
            d.discountName AS discount_name,
            d.discountPercentage AS discount_percentage,
            o.orderAddress,
            o.orderWard,
            o.orderDistrict,
            o.orderCity,
            o.orderStatus AS order_status,
            (
                SELECT GROUP_CONCAT(CONCAT(a.attributeName, ': ', pva.attributeValue) SEPARATOR ', ')
                FROM productvariantattributes pva
                LEFT JOIN attributes a ON pva.attributeId = a.attributeId
                WHERE pva.productVariantId = pv.productVariantId
                AND a.attributeName IN ('Màu', 'Dung lượng')
            ) AS variant_attributes
        FROM orderdetails od
        JOIN orders o ON od.orderId = o.orderId
        LEFT JOIN discounts d ON o.discountId = d.discountId
        LEFT JOIN productorders po ON od.orderDetailId = po.orderDetailId
        LEFT JOIN productvariants pv ON po.productVariantId = pv.productVariantId
        LEFT JOIN products p ON pv.productId = p.productId
        WHERE od.orderId = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Xử lý giao hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shipOrder'])) {
    $stmt = $conn->prepare("UPDATE orders SET orderStatus = 3 WHERE orderId = ? AND orderStatus = 2");
    $stmt->bind_param("i", $orderId);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Đơn hàng #' . $orderId . ' đã chuyển sang trạng thái "Đang giao hàng".</div>';
    } else {
        echo '<div class="alert alert-danger">Lỗi khi cập nhật trạng thái đơn hàng.</div>';
    }
}
// Xử lý khi người dùng nhấn nút "Đã nhận hàng"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmReceived'])) {
    $updateQuery = "UPDATE orders SET orderStatus = 4, orderPaymentStatus = 2 WHERE orderId = ? AND orderStatus = 3" ;
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Đơn hàng đã được cập nhật thành 'Hoàn thành'.";
        $_SESSION['msg_type'] = "success";
        header("Location: order-detail.php?orderId=$orderId"); // Reload lại trang chi tiết đơn hàng
        exit();
    } else {
        $_SESSION['message'] = "Lỗi khi cập nhật trạng thái đơn hàng.";
        $_SESSION['msg_type'] = "danger";
    }
}
$orders = getOrderDetail($orderId);
$total = 0;
$discount = 0;
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Chi tiết đơn hàng</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <?php if (!empty($orders)):
                                $orderStatus = $orders[0]['order_status'];
                                ?>
                            <p>Trạng thái đơn hàng:
                                <?php
                                    switch ($orderStatus) {
                                        case 1:
                                            echo '<span class="badge bg-warning">Chờ xác nhận</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge bg-info">Đang xử lý</span>';
                                            echo '<form method="POST" style="display:inline;">
                                            <input type="hidden" name="orderId" value="' . htmlspecialchars($orderId) . '">
                                            <button type="submit" name="shipOrder" class="btn btn-primary btn-sm">Giao hàng</button>
                                          </form>';
                                            break;
                                        case 3:
                                            echo '<span class="badge bg-primary">Đang giao hàng</span>';
                                            echo '<form method="POST" style="display:inline;">
                                            <button type="submit" name="confirmReceived" class="btn btn-success btn-sm">Đơn đã được vận chuyển</button>
                                            </form>';
                                            break;
                                        case 4:
                                            echo '<span class="badge bg-success">Hoàn thành</span>';
                                            break;
                                        case 5:
                                            echo '<span class="badge bg-danger">Đã hủy</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">Không xác định</span>';
                                    }
                                    ?>
                            </p>

                            <p>Địa chỉ giao hàng:
                                <span style="display: inline-block; max-width: 600px; white-space: normal;">
                                    <?= htmlspecialchars($addressResult['orderAddress']) ?>,
                                    <?= htmlspecialchars($wardName ?: '[Không tải được phường/xã]') ?>,
                                    <?= htmlspecialchars($districtName ?: '[Không tải được quận/huyện]') ?>,
                                    <?= htmlspecialchars($cityName ?: '[Không tải được tỉnh/thành]') ?>
                                </span>
                            </p>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order):
                                            $productTotal = $order['quantity'] * $order['price'];
                                            $total += $productTotal;
                                            ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="../images/<?= htmlspecialchars($order['image']) ?>"
                                                    alt="product"
                                                    style="width: 50px; height: 50px; margin-right: 10px;">
                                                <div>
                                                    <strong><?= htmlspecialchars($order['product_name']) ?></strong><br>
                                                    <small
                                                        class="text-muted"><?= htmlspecialchars($order['variant_attributes']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                                        <td><?= number_format($order['price'], 2) ?> VND</td>
                                        <td><?= number_format($productTotal, 2) ?> VND</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong><?= number_format($total, 2) ?> VND</strong></td>
                                    </tr>
                                    <?php if (!empty($orders[0]['discount_id'])):
                                            $discount = ($total * $orders[0]['discount_percentage']) / 100;
                                            ?>
                                    <tr>
                                        <td colspan="3" class="text-end">
                                            <strong>Khuyến mãi (<?= htmlspecialchars($orders[0]['discount_name']) ?> -
                                                <?= $orders[0]['discount_percentage'] ?>%)</strong>
                                        </td>
                                        <td><strong>-<?= number_format($discount, 2) ?> VND</strong></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Thành tiền:</strong></td>
                                        <td><strong><?= number_format($total - $discount, 2) ?> VND</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <p class="text-center">Không có sản phẩm nào trong đơn hàng.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include("../admin/includes/footer.php"); ?>