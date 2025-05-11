<?php
include("../admin/includes/header.php");
// Lấy tổng doanh thu từ các đơn hàng đã hoàn thành (orderStatus = 4)
$totalRevenueSql = "
    SELECT SUM(o.orderPrice - (o.orderPrice * IFNULL(d.discountPercentage, 0) / 100)) AS totalRevenue
    FROM orders o
    LEFT JOIN discounts d ON o.discountId = d.discountId
    WHERE o.orderStatus = 4
";
$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = 0;

if ($totalRevenueResult && $totalRevenueRow = $totalRevenueResult->fetch_assoc()) {
    $totalRevenue = $totalRevenueRow['totalRevenue'];
}
?>


<body>
    <div class="container-fluid mt-4">
        <div class="dashboard-header">
            <!-- Tổng số khách hàng -->
            <div class="dashboard-item customer">
                <div class="icon-container">
                    <i class="fas fa-user"></i>
                </div>
                <div class="text-container">
                    <p class="title">Khách hàng</p>
                    <h4 class="value"><?= totalValue('users') ?></h4>
                </div>
            </div>

            <!-- Tổng số sản phẩm -->
            <div class="dashboard-item product">
                <div class="icon-container">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="text-container">
                    <p class="title">Sản phẩm</p>
                    <h4 class="value mb-0"><?= totalValue('products') ?></h4>
                </div>
            </div>

            <!-- Tổng số đơn hàng -->
            <div class="dashboard-item order">
                <div class="icon-container">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="text-container">
                    <p class="title">Đơn hàng</p>
                    <h4 class="value"><?= totalValue('orders') ?></h4>
                </div>
            </div>
            <!-- Tổng doanh thu -->
            <div class="dashboard-item money">
                <div class="icon-container">
                    <i class="fas fa-money-bill"></i>
                </div>
                <div class="text-container">
                    <p class="title">Doanh thu</p>
                    <h4 class="value"><?= number_format($totalRevenue, 0, ',', '.') ?> đ</h4>
                </div>
            </div>

        </div>


        <!-- Biểu đồ doanh thu -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Biểu đồ Doanh Thu</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Lấy dữ liệu doanh thu của 12 tháng trong năm từ PHP
        const revenueData = <?php
        // Lấy dữ liệu doanh thu theo tháng cho năm hiện tại, chỉ tính các đơn hàng có orderStatus = 4
        $year = date('Y'); // Lấy năm hiện tại
        $start = "$year-01-01"; // Bắt đầu từ tháng 1 năm nay
        $end = "$year-12-31"; // Kết thúc vào tháng 12 năm nay
        $topUsersSql = "
            SELECT u.userId, u.userName, u.userEmail, o.orderId, o.create_at, o.orderPrice, d.discountPercentage
            FROM users u
            JOIN orders o ON u.userId = o.userId
            LEFT JOIN discounts d ON o.discountId = d.discountId
            WHERE o.create_at BETWEEN ? AND ? AND o.orderStatus = 4
        ";
        $stmt = $conn->prepare($topUsersSql);
        $stmt->bind_param("ss", $start, $end);
        $stmt->execute();
        $topUsersResult = $stmt->get_result();

        $monthlyRevenue = array_fill(0, 12, 0); // Khởi tạo mảng doanh thu cho 12 tháng
        
        while ($row = $topUsersResult->fetch_assoc()) {
            $orderPrice = $row['orderPrice'];
            $discount = isset($row['discountPercentage']) ? (int) $row['discountPercentage'] : 0;
            $finalPrice = $orderPrice - ($orderPrice * $discount / 100);

            $month = (int) date('m', strtotime($row['create_at'])) - 1;  // Chuyển đổi tháng thành chỉ số mảng (0-11)
            $monthlyRevenue[$month] += $finalPrice;  // Cập nhật doanh thu cho tháng tương ứng
        }

        // Trả về dữ liệu doanh thu
        echo json_encode([
            'months' => array_map(function ($month) {
                return str_pad($month + 1, 2, '0', STR_PAD_LEFT);
            }, range(0, 11)),
            'revenues' => $monthlyRevenue
        ]);
        ?>;

        // Cấu hình biểu đồ
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',  // Sử dụng biểu đồ đường
            data: {
                labels: revenueData.months.map(month => `${month}/<?= $year ?>`),  // Tháng và năm (01/2024, 02/2024, ...)
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenueData.revenues,  // Dữ liệu doanh thu
                    borderColor: '#4bc0c0',  // Màu đường
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Màu nền
                    fill: true,  // Điền màu nền cho biểu đồ
                    tension: 0.1  // Độ cong của đường
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Năm <?= $year ?>'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Doanh thu (VND)'
                        },
                        beginAtZero: true,  // Bắt đầu trục y từ 0
                        ticks: {
                            callback: function (value) {
                                return value.toLocaleString(); // Định dạng tiền tệ VND
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
<style>
    #card-body {
        width: 100%;
    }

    #revenueChart {
        width: 100%;
        height: 400px;
        /* Cố định chiều cao */
    }

    /* Chế độ tổng quan cho phần header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 20px;
        background-color: #f4f4f4;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Cấu trúc chung cho mỗi mục thống kê */
    .dashboard-item {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 30%;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    /* Hiệu ứng hover cho các mục */
    .dashboard-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    /* Kiểu cho các biểu tượng */
    .icon-container i {
        font-size: 40px;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    /* Màu sắc cho các biểu tượng */
    .dashboard-item.customer .icon-container i {
        color: #007bff;
    }

    .dashboard-item.product .icon-container i {
        color: #ff9800;
    }

    .dashboard-item.order .icon-container i {
        color: #4caf50;
    }

    /* Kiểu cho tiêu đề */
    .text-container .title {
        font-size: 14px;
        color: #888;
        margin: 0;
    }

    /* Kiểu cho giá trị (số lượng) */
    .text-container .value {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0 0;
        color: #333;
    }

    /* Điều chỉnh cho các màn hình nhỏ hơn */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
        }

        .dashboard-item {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
<?php include("../admin/includes/footer.php"); ?>