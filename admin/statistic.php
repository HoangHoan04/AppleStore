<?php
include("../admin/includes/header.php");

$productQuery = "
    SELECT 
        p.productId, p.productName, p.productLineId, p.categoryId, p.productStatus, p.create_at AS productCreateAt, 
        c.categoryName, c.categorySlug, c.categoryImage,pv.productVariantImage,
        pl.productLineName, pl.productLineDescription, a.attributeName, pva.attributeValue
    FROM products p
    LEFT JOIN productvariants pv ON p.productId = pv.productId
    LEFT JOIN categories c ON p.categoryId = c.categoryId
    LEFT JOIN productlines pl ON p.productLineId = pl.productLineId
    LEFT JOIN productvariantattributes pva ON pv.productVariantId = pva.productVariantId
    LEFT JOIN attributes a ON pva.attributeId = a.attributeId
    WHERE p.productStatus = 1
";
$productResult = mysqli_query($conn, $productQuery);
$userOrderStatsQuery = "
    SELECT 
        u.userId, u.userName, COUNT(o.orderId) AS totalOrders
    FROM users u
    LEFT JOIN orders o ON u.userId = o.userId
    GROUP BY u.userId, u.userName
    ORDER BY totalOrders DESC
";
$userOrderStatsResult = $conn->query($userOrderStatsQuery);
$userQuery = "
    SELECT 
        u.userId, u.userName, u.userEmail, u.userPhone, u.userAddress, u.userImage, u.create_at AS userCreateAt, u.userStatus 
    FROM users u
";
$userResult = mysqli_query($conn, $userQuery);

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


<div class="statistic-wrapper">
    <div class="filter-statistic">
        <div class="tab active" id="overviewTab" onclick="showTab('overview')">
            <span>Tổng quát</span>
        </div>
        <div class="tab" id="orderTab" onclick="showTab('order')">
            <span>Đơn hàng</span>
        </div>
        <div class="tab" id="productTab" onclick="showTab('product')">
            <span>Sản phẩm</span>
        </div>
        <div class="tab" id="userTab" onclick="showTab('user')">
            <span>Người dùng</span>
        </div>
    </div>

    <div class="statistic-container">
        <!-- Thống kê tổng quát -->
        <div class="statistic-page" id="overview">

            <div class="chart-container">
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

            </div>
            <div class="chart-container">
                <h4>Thống kê 5 khách hàng mua hàng nhiều nhất</h4>
                <form id="statistic-form" novalidate>
                    <div id="filter-container">
                        <div class="filter-item">
                            <label for="start_date">Từ ngày:</label>
                            <input type="date" id="start_date" name="start_date">
                        </div>
                        <div class="filter-item">
                            <label for="end_date">Đến ngày:</label>
                            <input type="date" id="end_date" name="end_date">
                        </div>
                        <button type="submit" id="filter-button">Thống kê</button>
                    </div>
                </form>
                <div id="result"></div>
            </div>

        </div>
        <!-- Thống kê đơn hàng -->
        <div class="statistic-page" id="order">
            <?php
            // Truy vấn tất cả đơn hàng và tính tổng tiền mua, cộng với tổng tiền sau khuyến mãi nếu có
            $ordersQuery = "
                SELECT o.orderId, o.userId, o.orderPrice, o.create_at AS orderCreateAt, o.orderStatus,
                    u.userName, u.userEmail, SUM(od.orderDetailQuantity * od.orderDetailPrice) AS totalAmount,
                    o.discountId, d.discountPercentage
                FROM orders o
                JOIN users u ON o.userId = u.userId
                JOIN orderdetails od ON o.orderId = od.orderId
                LEFT JOIN productorders po ON od.orderDetailId = po.orderDetailId
                LEFT JOIN discounts d ON o.discountId = d.discountId
                GROUP BY o.orderId, o.userId, o.orderPrice, o.create_at, o.orderStatus, u.userName, u.userEmail, o.discountId, d.discountPercentage
                ORDER BY totalAmount DESC  ";
            $ordersResult = $conn->query($ordersQuery);

            // Số lượng đơn hàng theo trạng thái
            $pendingOrders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 1")->fetch_assoc()['total'];
            $handleOrders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 2")->fetch_assoc()['total'];
            $shippingOrders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 3")->fetch_assoc()['total'];
            $completedOrders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 4")->fetch_assoc()['total'];
            $canceledOrders = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 5")->fetch_assoc()['total'];
            ?>

            <div class="chart-bar-container">
                <h4>Biểu đồ đơn hàng</h4>
                <canvas id="orderChart"></canvas>
            </div>

            <!-- Danh sách đơn hàng -->
            <div class="chart-container">
                <h4>Danh sách đơn hàng</h4>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên người dùng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $ordersResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $order['orderId'] ?></td>
                                <td><?= htmlspecialchars($order['userName']) ?></td>
                                <td>
                                    <?php
                                    // Kiểm tra nếu đơn hàng có khuyến mãi và tính tổng tiền sau khuyến mãi
                                    if ($order['discountPercentage'] > 0) {
                                        $discountAmount = ($order['totalAmount'] * $order['discountPercentage']) / 100;
                                        $finalAmount = $order['totalAmount'] - $discountAmount;
                                        echo "<strong>" . number_format($finalAmount) . " VND</strong>";
                                    } else {
                                        echo "<strong>" . number_format($order['totalAmount']) . " VND</strong>";
                                    }
                                    ?>
                                </td>
                                <td><?= $order['orderCreateAt'] ?></td>
                                <td>
                                    <span
                                        class="badge <?= $order['orderStatus'] == '1' ? 'bg-warning' : ($order['orderStatus'] == '2' ? 'bg-info' : ($order['orderStatus'] == '3' ? 'bg-primary' : ($order['orderStatus'] == '4' ? 'bg-success' : 'bg-danger'))) ?>">
                                        <?= $order['orderStatus'] == '1' ? "Chờ xác nhận" : ($order['orderStatus'] == '2' ? "Đang xử lý" : ($order['orderStatus'] == '3' ? "Đang vận chuyển" : ($order['orderStatus'] == '4' ? "Hoàn thành" : "Đã hủy"))) ?>
                                    </span>
                                </td>
                                <td><a href="order-detail.php?orderId=<?= $order['orderId'] ?>" class="btn btn-info">Xem
                                        chi
                                        tiết</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Thống kê sản phẩm -->
        <div class="statistic-page active" id="product">
            <?php
            $activeProducts = $conn->query("SELECT COUNT(*) AS total FROM products WHERE productStatus = 1")->fetch_assoc()['total'];
            ?>
            <div class="product-box">
                <div class="statistic-box">
                    <h2><?= $activeProducts ?></h2>
                    <p>Sản phẩm đang hoạt động</p>
                </div>
            </div>
            <?php
            $limit = 5;
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $page = max($page, 1);
            $offset = ($page - 1) * $limit;
            $totalProductQuery = $conn->query("SELECT COUNT(DISTINCT p.productName) AS total 
                FROM products p 
                JOIN productlines pl ON p.productLineId = pl.productLineId 
                JOIN categories c ON p.categoryId = c.categoryId     
                WHERE p.productStatus = 1");
            $totalProducts = $totalProductQuery->fetch_assoc()['total'];
            $totalPages = ceil($totalProducts / $limit);
            $productResult = $conn->query("
                SELECT p.productName, p.create_at AS productCreateAt, pv.productVariantImage, c.categoryName, pl.productLineName
                FROM products p
                JOIN productvariants pv ON p.productId = pv.productId
                JOIN categories c ON p.categoryId = c.categoryId
                JOIN productlines pl ON p.productLineId = pl.productLineId
                WHERE p.productStatus = 1
                GROUP BY p.productName
                ORDER BY productCreateAt DESC
                LIMIT $limit OFFSET $offset");
            ?>
            <!-- Danh sách sản phẩm -->
            <div class="chart-container">
                <h4>Danh sách sản phẩm</h4>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Thể loại</th>
                            <th>Dòng sản phẩm</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $displayedProducts = [];
                        while ($product = mysqli_fetch_assoc($productResult)) {
                            if (!in_array($product['productName'], $displayedProducts)) {
                                $displayedProducts[] = $product['productName'];
                                ?>
                                <tr>
                                    <td><?php echo $product['productName']; ?></td>
                                    <td><img src="../images/<?= $product['productVariantImage']; ?>" alt="Product Image"
                                            width="100"></td>
                                    <td><?php echo $product['categoryName']; ?></td>
                                    <td><?php echo $product['productLineName']; ?></td>
                                    <td><?php echo $product['productCreateAt']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>">&laquo; Trước</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>">Sau &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="chart-container">
                <?php
                // Truy vấn 5 sản phẩm bán chạy nhất
                $topProductsQuery = "
                    SELECT po.productVariantId, SUM(od.orderDetailQuantity) AS quantity, pv.productId, p.productName, pv.productVariantImage, pv.price
                    FROM productorders po
                    JOIN productvariants pv ON po.productVariantId = pv.productVariantId
                    JOIN orderdetails od ON po.orderDetailId = od.orderDetailId
                    JOIN products p ON pv.productId = p.productId
                    GROUP BY po.productVariantId
                    ORDER BY quantity DESC
                    LIMIT 5
                ";
                $topProductsResult = $conn->query($topProductsQuery);

                // Hiển thị 5 sản phẩm bán chạy nhất
                if ($topProductsResult->num_rows > 0) {
                    echo "<div class='top-products'>";
                    echo "<h4>5 Sản phẩm bán chạy nhất</h4>";
                    echo "<table border='1' cellpadding='10' cellspacing='0'>";
                    echo "<thead><tr><th>Mã sản phẩm</th><th>Tên sản phẩm</th><th>Ảnh sản phẩm</th><th>Số lượng bán</th><th>Giá</th></tr></thead>";
                    echo "<tbody>";

                    while ($product = $topProductsResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $product['productVariantId'] . "</td>";
                        echo "<td>" . htmlspecialchars($product['productName']) . "</td>";
                        echo "<td><img src='../images/" . $product['productVariantImage'] . "' alt='" . htmlspecialchars($product['productName']) . "' width='50'></td>";
                        echo "<td>" . htmlspecialchars(number_format($product['quantity'])) . "</td>";
                        echo "<td>" . number_format($product['price'], 0, ',', '.') . " VND</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Không có dữ liệu sản phẩm bán chạy.</p>";
                }
                ?>
            </div>
            <?php
            $sqlProductStats = " SELECT pl.productLineName,
                c.categoryName,
                COUNT(p.productId) AS totalProducts
                FROM products p
                JOIN productlines pl ON p.productLineId = pl.productLineId
                JOIN categories c ON p.categoryId = c.categoryId
                WHERE p.productStatus = 1
                GROUP BY pl.productLineName, c.categoryName
            ";
            $productStatsResult = $conn->query($sqlProductStats);
            ?>
            <div class="chart-container">
                <h4>Thống kê theo dòng sản phẩm và thể loại</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Dòng sản phẩm</th>
                            <th>Thể loại</th>
                            <th>Số lượng sản phẩm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $productStatsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['productLineName']) ?></td>
                                <td><?= htmlspecialchars($row['categoryName']) ?></td>
                                <td><?= $row['totalProducts'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Thống kê người dùng -->
        <div class="statistic-page" id="user">
            <?php
            $activeUsers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE userStatus = 1")->fetch_assoc()['total'];
            $lockedUsers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE userStatus = 0")->fetch_assoc()['total'];
            ?>
            <div class="user-box">
                <div class="statistic-box">
                    <h2><?= $activeUsers ?></h2>
                    <p>Người dùng đang hoạt động</p>
                </div>
                <div class="statistic-box">
                    <h2><?= $lockedUsers ?></h2>
                    <p>Người dùng đã khóa</p>
                </div>
            </div>
            <div class="chart-container">
                <h4>Danh sách người dùng</h4>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Ảnh đại diện</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ngày đăng ký</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($userResult)): ?>
                            <tr>
                                <td>
                                    <?php if ($user['userImage']): ?>
                                        <img src="../images/<?= $user['userImage'] ?>" alt="User Image">
                                    <?php else: ?>
                                        <img src="../images/userImageDefault.png" alt="Default User">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['userName']) ?></td>
                                <td><?= htmlspecialchars($user['userEmail']) ?></td>
                                <td><?= htmlspecialchars($user['userPhone']) ?></td>
                                <td><?= htmlspecialchars($user['userAddress']) ?></td>
                                <td><?= $user['userCreateAt'] ?></td>
                                <td>
                                    <span class="badge <?= $user['userStatus'] == '1' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?= $user['userStatus'] == '1' ? "Đang hoạt động" : "Đã khóa"; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function showTab(tabName) {
        document.querySelectorAll('.statistic-page').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
        document.getElementById(tabName + 'Tab').classList.add('active');
        localStorage.setItem('currentTab', tabName);
    }
    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = localStorage.getItem('currentTab') || 'overview'; // Mặc định là overview
        showTab(savedTab);
    });

    const orderChart = document.getElementById('orderChart');
    const productLineChart = document.getElementById('productLineChart');
    const categoryChart = document.getElementById('categoryChart');
    // Biểu đồ đơn hàng
    new Chart(orderChart, {
        type: 'bar',
        data: {
            labels: ['Chờ xác nhận', 'Đang xử lý', 'Đang vận chuyển', 'Đã hoàn thành', "Đã hủy"],
            datasets: [{
                label: 'Trạng thái đơn hàng',
                data: [<?= $pendingOrders ?>, <?= $handleOrders ?>, <?= $shippingOrders ?>, <?= $completedOrders ?>, <?= $canceledOrders ?>],
                backgroundColor: [
                    '#ffc107', // Đơn chờ xử lý
                    '#17a2b8', // Đơn đang xử lý
                    '#007bff', // Đơn đang giao
                    '#28a745', // Đơn hoàn thành
                    '#dc3545'  // Đơn đã hủy
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function viewOrder(orderId) {
        window.location.href = 'order-detail.php?orderId=' + orderId;
    }
    document.getElementById('statistic-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn reload trang

        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;
        const result = document.getElementById('result');

        // Tạo dữ liệu gửi đi
        let body = `orderStatus=4`;
        if (start && end) {
            body += `&start_date=${encodeURIComponent(start)}&end_date=${encodeURIComponent(end)}`;
        }

        // Gửi request
        fetch('fetch_top_users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: body
        })
            .then(response => response.text())
            .then(data => {
                result.innerHTML = data;
            })
            .catch(error => {
                console.error('Lỗi:', error);
                result.innerHTML = '<p style="color: red;">Đã xảy ra lỗi khi lấy dữ liệu.</p>';
            });
    });

</script>


<style>
    #orderChart {
        padding: 10px;
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    #filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end;
        justify-content: space-between;
    }

    .filter-item {
        display: flex;
        flex-direction: column;
        flex: 1 1 45%;
        min-width: 200px;
    }

    .filter-item label {
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    .filter-item input[type="date"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .filter-item input[type="date"]:focus {
        border-color: #007bff;
        outline: none;
    }

    #filter-button {
        padding: 12px 20px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        flex-shrink: 0;
        margin: auto;
    }

    #filter-button:hover {
        background-color: #0056b3;
    }

    .user-list {
        margin-top: 20px;
    }

    .user-row {
        border: 1px solid #ddd;
        margin-bottom: 10px;
        padding: 10px;
    }

    .user-info {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        background-color: #f9f9f9;
        padding: 10px;
    }

    .user-name {
        font-size: 18px;
        color: #333;
    }

    .total-spent {
        font-size: 16px;
        color: #e74c3c;
    }

    .order-list {
        padding: 10px;
        background-color: #fafafa;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        border-bottom: 1px solid #ddd;
        padding: 8px 0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-id,
    .order-date,
    .order-price {
        flex: 1;
        text-align: center;
    }

    .btn-view {
        background-color: #3498db;
        color: white;
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-left: 10px;
    }

    .btn-view:hover {
        background-color: #2980b9;
    }

    .filter-statistic {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        background: #007bff;
        border-radius: 8px;
        overflow: hidden;
    }

    .filter-statistic .tab {
        flex: 1;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        background: #f1f1f1;
        transition: background 0.3s ease;
    }

    .filter-statistic .tab:hover {
        background: #007bff;
        color: #fff;
    }

    .filter-statistic .tab.active {
        background: #007bff;
        color: #fff;
    }

    .statistic-wrapper {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
        color: #555;
        transition: background-color 0.3s ease;
    }

    .tab:hover {
        background-color: #f1f1f1;
    }

    .tab.active {
        background-color: #007bff;
        color: white;
    }

    .statistic-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .statistic-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%;
    }

    .statistic-box h2 {
        font-size: 2rem;
        color: #007bff;
    }

    .statistic-box p {
        margin-top: 10px;
        color: #555;
        font-size: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    table td {
        background-color: #f9f9f9;
    }

    table tbody tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    table img {
        width: 50px;
        height: auto;
        border-radius: 4px;
    }

    .chart-container {
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chart-container h4 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .chart-bar-container {
        margin-top: 40px;
        text-align: center;
    }

    canvas {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .user-table th,
    .user-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .user-table th {
        background-color: #007bff;
        color: white;
    }

    .user-table td {
        background-color: #f9f9f9;
    }

    .user-table tbody tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    .user-table img {
        width: 50px;
        height: auto;
        border-radius: 4px;
    }

    .statistic-page {
        display: none;
    }

    .statistic-page.active {
        display: block;
    }

    .statistic-box:hover {
        background-color: #e2f0ff;
        transform: translateY(-5px);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .tab:hover {
        background-color: #0056b3;
    }

    .product-box,
    .user-box,
    .order-box {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        width: 100%;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
        text-align: center;
    }

    .pagination a {
        padding: 8px 12px;
        margin: 0 5px;
        background-color: #f2f2f2;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
    }
</style>

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