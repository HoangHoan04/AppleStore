<?php
include("../config/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';

    $params = [];
    $types = '';
    $where = "WHERE o.orderStatus = 4";

    $filterByDate = !empty($start) && !empty($end);

    if ($filterByDate) {

        if ($start === $end) {
            // Nếu là cùng 1 ngày
            $start .= ' 00:00:00';
            $end .= ' 23:59:59';
        } else {
            $start .= ' 00:00:00';
            $end .= ' 23:59:59';
        }
        $where .= " AND o.create_at BETWEEN ? AND ?";
        $params[] = $start;
        $params[] = $end;
        $types = "ss";
    }

    $sql = "
        SELECT u.userId, u.userName, u.userEmail, o.orderId, o.create_at, o.orderPrice, d.discountPercentage
        FROM users u
        JOIN orders o ON u.userId = o.userId
        LEFT JOIN discounts d ON o.discountId = d.discountId
        $where
    ";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $userOrders = [];

    while ($row = $result->fetch_assoc()) {
        $userId = $row['userId'];
        $orderPrice = $row['orderPrice'];
        $discount = isset($row['discountPercentage']) ? (int) $row['discountPercentage'] : 0;
        $finalPrice = $orderPrice - ($orderPrice * $discount / 100);

        if (!isset($userOrders[$userId])) {
            $userOrders[$userId] = [
                'userName' => $row['userName'],
                'userEmail' => $row['userEmail'],
                'total_spent' => 0,
                'orders' => []
            ];
        }

        $userOrders[$userId]['total_spent'] += $finalPrice;
        $userOrders[$userId]['orders'][] = [
            'orderId' => $row['orderId'],
            'create_at' => $row['create_at'],
            'finalPrice' => $finalPrice
        ];
    }

    // Luôn sắp xếp theo tổng chi tiêu giảm dần
    uasort($userOrders, fn($a, $b) => $b['total_spent'] <=> $a['total_spent']);

    // Nếu lọc theo ngày thì chỉ lấy top 5
    if ($filterByDate) {
        $userOrders = array_slice($userOrders, 0, 5, true);
    }

    if (count($userOrders) > 0) {
        echo "<div class='chart-container'>";
        echo "<h4>Kết quả " . ($filterByDate ? "từ " . date('d/m/Y H:i', strtotime($start)) . " đến " . date('d/m/Y H:i', strtotime($end)) . " (Top 5 khách hàng)" : "cho tất cả thời gian (Tất cả khách hàng)") . "</h4>";
        echo "<div class='user-list'>";

        foreach ($userOrders as $user) {
            echo "<div class='user-row'>";
            echo "<div class='user-info'>
                    <span class='user-name'>Họ tên khách hàng: {$user['userName']}</span><br>
                    <span class='user-email'>Email: {$user['userEmail']}</span><br>
                    <span class='total-spent'>Tổng chi tiêu: " . number_format($user['total_spent'], 0, ',', '.') . "đ</span>
                  </div>";
            echo "<div class='order-list'>";
            foreach ($user['orders'] as $order) {
                echo "<div class='order-item'>
                        <span class='order-id'>Mã đơn: {$order['orderId']}</span>
                        <span class='order-date'>Ngày tạo: {$order['create_at']}</span>
                        <span class='order-price'>Thành tiền: " . number_format($order['finalPrice'], 0, ',', '.') . "đ</span>
                        <button class='btn-view' onclick='viewOrder({$order['orderId']})'>Xem</button>
                      </div>";
            }
            echo "</div>"; // order-list
            echo "</div>"; // user-row
        }

        echo "</div>"; // user-list
        echo "</div>"; // chart-container
    } else {
        echo "<p>Không có dữ liệu trong khoảng thời gian đã chọn.</p>";
    }
}
?>