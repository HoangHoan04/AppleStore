<?php
ob_start();
include("./includes/header.php");

// Hàm lấy tên địa phương từ API
function fetchAddressName($type, $id, $districtId = null) {
    if ($type === 'w') {
        // Lấy danh sách wards từ quận
        if (!$districtId) return null;
        $url = "https://provinces.open-api.vn/api/d/$districtId?depth=2";
        $data = @file_get_contents($url);
        if ($data === false) return null;
        $json = json_decode($data, true);
        if (!isset($json['wards'])) return null;

        foreach ($json['wards'] as $ward) {
            if ($ward['code'] == $id) {
                return $ward['name'];
            }
        }
        return null;
    } else {
        $url = "https://provinces.open-api.vn/api/$type/$id";
        $data = @file_get_contents($url);
        if ($data === false) return null;
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
function getOrderDetail($orderId) {
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
$orders = getOrderDetail($orderId);
$total = 0;
$discount = 0;

// Xử lý khi người dùng nhấn nút "Đã nhận hàng"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmReceived'])) {
    $updateQuery = "UPDATE orders SET orderStatus = 4, orderPaymentStatus = 2 WHERE orderId = ? AND orderStatus = 3" ;
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        header("Location: user.php"); // Chuyển hướng đến trang lịch sử mua hàng
        exit();
    } else {
        echo '<div class="alert alert-danger">Lỗi khi cập nhật trạng thái đơn hàng.</div>';
    }
}
// Xử lý khi người dùng nhấn nút "Hủy đơn hàng"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelOrder'])) {
    $updateQuery = "UPDATE orders SET orderStatus = 5 WHERE orderId = ? AND orderStatus = 2";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Đơn hàng đã được hủy thành công.";
        $_SESSION['msg_type'] = "success";
        header("Location: order_detail.php?orderId=$orderId"); // Reload lại trang chi tiết đơn hàng
        exit();
    } else {
        $_SESSION['message'] = "Lỗi khi hủy đơn hàng.";
        $_SESSION['msg_type'] = "danger";
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
        header("Location: order_detail.php?orderId=$orderId"); // Reload lại trang chi tiết đơn hàng
        exit();
    } else {
        $_SESSION['message'] = "Lỗi khi cập nhật trạng thái đơn hàng.";
        $_SESSION['msg_type'] = "danger";
    }
}

?>

<body>
    <div class="container py-5">
        <h2>Chi tiết đơn hàng</h2>
        <?php if (!empty($orders)) {
            $orderStatus = $orders[0]['order_status']; // Lấy trạng thái từ đơn hàng đầu tiên
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
                                <button type="submit" name="cancelOrder" class="btn btn-danger btn-sm">Hủy đơn hàng</button>
                              </form>';
                        break;
                    case 3:
                        echo '<span class="badge bg-primary">Đang giao hàng</span>';
                        echo '<form method="POST" style="display:inline;">
                                <button type="submit" name="confirmReceived" class="btn btn-success btn-sm">Đã nhận hàng</button>
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
                        break;
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) {
                        $productTotal = $order['quantity'] * $order['price'];
                        $total += $productTotal;
                        ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="./images/<?= htmlspecialchars($order['image']) ?>" alt="product"
                                style="width: 50px; height: 50px; margin-right: 10px;">
                            <div>
                                <strong><?= htmlspecialchars($order['product_name']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($order['variant_attributes']) ?></small>
                            </div>
                        </div>
                    </td>

                    <td><?= htmlspecialchars($order['quantity']) ?></td>
                    <td><?= number_format($order['price'], 2) ?> VND</td>
                    <td><?= number_format($productTotal, 2) ?> VND</td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                    <td><strong><?= number_format($total, 2) ?> VND</strong></td>
                </tr>
                <?php if (!empty($orders[0]['discount_id'])) {
                        $discount = ($total * $orders[0]['discount_percentage']) / 100;
                        ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Khuyến mãi
                            (<?= htmlspecialchars($orders[0]['discount_name']) ?> -
                            <?= $orders[0]['discount_percentage'] ?>%):</strong></td>
                    <td><strong>-<?= number_format($discount, 2) ?> VND</strong></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Thành tiền:</strong></td>
                    <td><strong><?= number_format($total - $discount, 2) ?> VND</strong></td>
                </tr>
            </tbody>
        </table>
        <?php } else { ?>
        <p>Không có sản phẩm nào trong đơn hàng.</p>
        <?php } ?>
    </div>
</body>
<?php include("./includes/footer.php"); ?>