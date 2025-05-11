<?php
include("./includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['message'] = "Vui lòng đăng nhập để xem trạng thái đơn hàng!";
    $_SESSION['msg_type'] = "error";
    header("Location: login.php");
    exit();
}

// Lấy thông tin user
$userId = $_SESSION['auth_user']['userId'];

// Lấy giá trị bộ lọc từ GET (mặc định là 0 - hiển thị tất cả)
$statusFilter = isset($_GET['status']) ? (int) $_GET['status'] : 0;
$paymentMethodFilter = isset($_GET['payment_method']) ? (int) $_GET['payment_method'] : 0;
$paymentStatusFilter = isset($_GET['payment_status']) ? (int) $_GET['payment_status'] : 0;

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
                WHEN 1 THEN 'Chờ xác nhận'
                WHEN 2 THEN 'Đang xử lý'
                WHEN 3 THEN 'Đang giao hàng'
                WHEN 4 THEN 'Hoàn thành'
                WHEN 5 THEN 'Đã hủy'
                ELSE 'Không xác định'
            END AS orderStatus
          FROM orders o
          WHERE o.userId = ? 
          AND o.orderStatus IN (1, 2, 3)" .
    ($statusFilter > 0 ? " AND o.orderStatus = ?" : "") .
    ($paymentMethodFilter > 0 ? " AND o.orderPaymentMethod = ?" : "") .
    ($paymentStatusFilter > 0 ? " AND o.orderPaymentStatus = ?" : "") .
    " ORDER BY o.create_at DESC";

$stmt = $conn->prepare($query);

// Bind các tham số dựa trên bộ lọc
if ($statusFilter > 0 && $paymentMethodFilter > 0 && $paymentStatusFilter > 0) {
    $stmt->bind_param("iiii", $userId, $statusFilter, $paymentMethodFilter, $paymentStatusFilter);
} elseif ($statusFilter > 0 && $paymentMethodFilter > 0) {
    $stmt->bind_param("iii", $userId, $statusFilter, $paymentMethodFilter);
} elseif ($statusFilter > 0 && $paymentStatusFilter > 0) {
    $stmt->bind_param("iii", $userId, $statusFilter, $paymentStatusFilter);
} elseif ($paymentMethodFilter > 0 && $paymentStatusFilter > 0) {
    $stmt->bind_param("iii", $userId, $paymentMethodFilter, $paymentStatusFilter);
} elseif ($statusFilter > 0) {
    $stmt->bind_param("ii", $userId, $statusFilter);
} elseif ($paymentMethodFilter > 0) {
    $stmt->bind_param("ii", $userId, $paymentMethodFilter);
} elseif ($paymentStatusFilter > 0) {
    $stmt->bind_param("ii", $userId, $paymentStatusFilter);
} else {
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="order-container">
    <div class="header-section">
        <h2 class="title mb-3 text-center">Danh sách đơn hàng của bạn</h2>

        <div class="filter-section mb-3 ">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label for="status-filter">Trạng thái đơn hàng:</label>
                    <select name="status" id="status-filter" onchange="this.form.submit()">
                        <option value="0" <?= $statusFilter == 0 ? 'selected' : '' ?>>Tất cả</option>
                        <option value="1" <?= $statusFilter == 1 ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="2" <?= $statusFilter == 2 ? 'selected' : '' ?>>Đang xử lý</option>
                        <option value="3" <?= $statusFilter == 3 ? 'selected' : '' ?>>Đang giao hàng</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="payment-method-filter">Phương thức thanh toán:</label>
                    <select name="payment_method" id="payment-method-filter" onchange="this.form.submit()">
                        <option value="0" <?= $paymentMethodFilter == 0 ? 'selected' : '' ?>>Tất cả</option>
                        <option value="1" <?= $paymentMethodFilter == 1 ? 'selected' : '' ?>>Tiền mặt</option>
                        <option value="2" <?= $paymentMethodFilter == 2 ? 'selected' : '' ?>>Chuyển khoản</option>
                        <option value="3" <?= $paymentMethodFilter == 3 ? 'selected' : '' ?>>Thẻ tín dụng</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="payment-status-filter">Trạng thái thanh toán:</label>
                    <select name="payment_status" id="payment-status-filter" onchange="this.form.submit()">
                        <option value="0" <?= $paymentStatusFilter == 0 ? 'selected' : '' ?>>Tất cả</option>
                        <option value="1" <?= $paymentStatusFilter == 1 ? 'selected' : '' ?>>Chưa thanh toán</option>
                        <option value="2" <?= $paymentStatusFilter == 2 ? 'selected' : '' ?>>Đã thanh toán</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <table class="order-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Số lượng</th>
                <th>Phương thức <br> thanh toán</th>
                <th>Trạng thái <br> thanh toán</th>
                <th>Trạng thái <br> đơn hàng</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>

                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['orderId']) ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($order['orderDate']))) ?></td>
                        <td><?= number_format($order['totalAmount'], 0, ',', '.') ?> VND</td>
                        <td><?= htmlspecialchars($order['orderQuantity']) ?></td>
                        <td><?= htmlspecialchars($order['paymentMethod']) ?></td>
                        <td>
                            <span class="status <?= $order['paymentStatus'] === 'Đã thanh toán' ? 'paid' : 'unpaid' ?>">
                                <?= htmlspecialchars($order['paymentStatus']) ?>
                            </span>
                        </td>
                        <td>
                            <span
                                class="status <?= $order['orderStatus'] === 'Đang xử lý' ? 'processing' : ($order['orderStatus'] === 'Chờ xác nhận' ? 'pending' : ($order['orderStatus'] === 'Đã giao hàng' || $order['orderStatus'] === 'Hoàn thành' ? 'paid' : 'unpaid')) ?>">
                                <?= htmlspecialchars($order['orderStatus']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="order_detail.php?orderId=<?= htmlspecialchars($order['orderId']) ?>"
                                class="btn-view">Xem</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Không có đơn hàng nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include("./includes/footer.php"); ?>

<style>
    .order-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-size: 13px;
    }

    <<<<<<< Updated upstream .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 24px;
        color: #333;
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

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .order-table th {
        background: #007bff;
        color: white;
        font-weight: 600;
    }

    .order-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .order-table tr:hover {
        background: #f1f1f1;
    }

    .status {
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        color: white;
        display: inline-block;
    }

    .paid {
        background: #28a745;
    }

    .unpaid {
        background: #dc3545;
    }

    .processing {
        background: #ffc107;
        color: black;
    }

    .pending {
        background: #17a2b8;
    }

    .btn-view {
        padding: 5px 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-view:hover {
        background: #0056b3;
    }

    /* Responsive */
    @media (max-width: 768px) {
        =======>>>>>>>Stashed changes .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .filter-section {
            display: flex;
            align-items: center;
        }

        .filter-form {
            <<<<<<< Updated upstream flex-direction: column;
            width: 100%;
            gap: 15px;
        }

        .filter-group {
            width: 100%;
            =======display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-form label {
            font-size: 14px;
            color: #555;
            font-weight: 500;
            >>>>>>>Stashed changes
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
        }

        .filter-form select:hover {
            border-color: #007bff;
        }

        .filter-form select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th,
        .order-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .order-table th {
            background: #007bff;
            color: white;
            font-weight: 600;
        }

        .order-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .order-table tr:hover {
            background: #f1f1f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .paid {
            background: #28a745;
        }

        .unpaid {
            background: #dc3545;
        }

        .processing {
            background: #ffc107;
            color: black;
        }

        .pending {
            background: #17a2b8;
        }

        .btn-view {
            padding: 5px 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-view:hover {
            background: #0056b3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .filter-form {
                width: 100%;
                justify-content: flex-start;
            }

            .filter-form select {
                width: 100%;
            }
        }
</style>