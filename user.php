<?php
include("./includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['message'] = "Vui lòng đăng nhập để xem lịch sử mua hàng!";
    $_SESSION['msg_type'] = "error";
    header("Location: login.php");
    exit();
}

// Lấy thông tin user
$userId = $_SESSION['auth_user']['userId'];

// Lấy giá trị bộ lọc từ GET (mặc định là 0 - hiển thị tất cả)
$statusFilter = isset($_GET['status']) ? (int) $_GET['status'] : 0;
$paymentMethodFilter = isset($_GET['payment_method']) ? (int) $_GET['payment_method'] : 0;

// Truy vấn SQL với các bộ lọc
$query = "SELECT 
            o.orderId,
            o.create_at AS orderDate,
            o.orderPrice AS totalAmount,
            o.orderQuantity,
            CASE o.orderPaymentMethod
                WHEN 1 THEN 'Tiền mặt'
                WHEN 2 THEN 'Chuyển khoản'
                WHEN 3 THEN 'Thẻ tín dụng'
                ELSE 'Không xác định'
            END AS paymentMethod,
            CASE o.orderPaymentStatus
                WHEN 1 THEN 'Chưa thanh toán'
                WHEN 2 THEN 'Đã thanh toán'
                ELSE 'Không xác định'
            END AS paymentStatus,
            CASE o.orderStatus
                WHEN 4 THEN 'Hoàn thành'
                WHEN 5 THEN 'Đã hủy'
                ELSE 'Không xác định'
            END AS orderStatus
          FROM orders o
          WHERE o.userId = ? 
          AND o.orderStatus IN (4, 5)" .
    ($statusFilter > 0 ? " AND o.orderStatus = ?" : "") .
    ($paymentMethodFilter > 0 ? " AND o.orderPaymentMethod = ?" : "") .
    " ORDER BY o.create_at DESC";

$stmt = $conn->prepare($query);

// Bind các tham số dựa trên bộ lọc
if ($statusFilter > 0 && $paymentMethodFilter > 0) {
    $stmt->bind_param("iii", $userId, $statusFilter, $paymentMethodFilter);
} elseif ($statusFilter > 0) {
    $stmt->bind_param("ii", $userId, $statusFilter);
} elseif ($paymentMethodFilter > 0) {
    $stmt->bind_param("ii", $userId, $paymentMethodFilter);
} else {
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!-- Lịch sử mua hàng -->
<div class="container order-history">
    <div class="header-section">
        <h2 class="title">Lịch sử mua hàng</h2>
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label for="status-filter">Trạng thái:</label>
                    <select name="status" id="status-filter" onchange="this.form.submit()">
                        <option value="0" <?= $statusFilter == 0 ? 'selected' : '' ?>>Tất cả</option>
                        <option value="4" <?= $statusFilter == 4 ? 'selected' : '' ?>>Hoàn thành</option>
                        <option value="5" <?= $statusFilter == 5 ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="payment-method-filter">Phương thức:</label>
                    <select name="payment_method" id="payment-method-filter" onchange="this.form.submit()">
                        <option value="0" <?= $paymentMethodFilter == 0 ? 'selected' : '' ?>>Tất cả</option>
                        <option value="1" <?= $paymentMethodFilter == 1 ? 'selected' : '' ?>>Tiền mặt</option>
                        <option value="2" <?= $paymentMethodFilter == 2 ? 'selected' : '' ?>>Chuyển khoản</option>
                        <option value="3" <?= $paymentMethodFilter == 3 ? 'selected' : '' ?>>Thẻ tín dụng</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($orders)): ?>
        <div class="table-responsive">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Số lượng</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['orderId']) ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['orderDate']))) ?></td>
                            <td><span class="price"><?= number_format($order['totalAmount'], 0, ',', '.') ?> VND</span></td>
                            <td><i class="fas fa-box"></i> <?= htmlspecialchars($order['orderQuantity']) ?></td>
                            <td><?= htmlspecialchars($order['paymentMethod']) ?></td>
                            <td>
                                <span class="status <?= $order['paymentStatus'] === 'Đã thanh toán' ? 'paid' : 'unpaid' ?>">
                                    <?= htmlspecialchars($order['paymentStatus']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="status <?= $order['orderStatus'] === 'Hoàn thành' ? 'paid' : 'unpaid' ?>">
                                    <?= htmlspecialchars($order['orderStatus']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="order_detail.php?orderId=<?= htmlspecialchars($order['orderId']) ?>"
                                    class="btn-view">Xem</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-orders"><i class="fas fa-shopping-bag"></i> Không có đơn hàng nào trong lịch sử của bạn.</p>
    <?php endif; ?>
</div>

<?php include("./includes/footer.php"); ?>

<style>
    .order-history {
        max-width: 1350px;
        margin: 30px auto;
        padding: 25px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 28px;
        color: #2c3e50;
        font-weight: 600;
        margin: 0;
    }

    .filter-section {
        display: flex;
        align-items: center;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-form label {
        font-size: 14px;
        color: #555;
        font-weight: 500;
    }

    .filter-form select {
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #f9f9f9;
        color: #333;
        outline: none;
        cursor: pointer;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        min-width: 150px;
    }

    .filter-form select:hover {
        border-color: #007bff;
    }

    .filter-form select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .order-table th,
    .order-table td {
        padding: 15px;
        border: 1px solid #e0e0e0;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
    }

    .order-table th {
        background: #007bff;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
    }

    .order-table tr:nth-child(even) {
        background: #f8f9fa;
    }

    .order-table tr:hover {
        background: #eef2f7;
        transition: background 0.3s ease;
    }

    .price {
        color: #e74c3c;
        font-weight: 600;
    }

    .status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .paid {
        background: #28a745;
        color: #fff;
    }

    .unpaid {
        background: #dc3545;
        color: #fff;
    }

    .btn-view {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 13px;
        transition: background 0.3s ease;
    }

    .btn-view:hover {
        background: #0056b3;
    }

    .btn-view i {
        margin-right: 5px;
    }

    .no-orders {
        text-align: center;
        font-size: 16px;
        color: #7f8c8d;
        padding: 20px;
    }

    .no-orders i {
        margin-right: 10px;
        color: #bdc3c7;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .filter-form {
            flex-direction: column;
            width: 100%;
            gap: 15px;
        }

        .filter-group {
            width: 100%;
        }

        .filter-form select {
            width: 100%;
        }

        .order-table th,
        .order-table td {
            padding: 10px;
            font-size: 12px;
        }

        .btn-view {
            padding: 6px 10px;
            font-size: 12px;
        }

        .title {
            font-size: 24px;
        }
    }
</style>