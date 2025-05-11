<?php
ob_start(); // Bật bộ đệm đầu ra
include("../admin/includes/header.php");
// Tạo context để bỏ qua SSL verify
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Content-Type: application/json\r\n"
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false
    ]
];
$context = stream_context_create($opts);

$provinceData = json_decode(file_get_contents("https://provinces.open-api.vn/api/p/", false, $context), true);
$districtData = json_decode(file_get_contents("https://provinces.open-api.vn/api/d/", false, $context), true);
$wardData = json_decode(file_get_contents("https://provinces.open-api.vn/api/w/", false, $context), true);

$provinceNameToCode = [];
foreach ($provinceData as $p) {
    $provinceNameToCode[$p['name']] = $p['code'];
}
$districtNameToCode = [];
foreach ($districtData as $d) {
    $districtNameToCode[$d['name']] = $d['code'];
}
$wardNameToCode = [];
foreach ($wardData as $w) {
    $wardNameToCode[$w['name']] = $w['code'];
}

// Xử lý cập nhật trạng thái đơn hàng
if (isset($_GET['confirm_id']) && is_numeric($_GET['confirm_id'])) {
    $orderId = $_GET['confirm_id'];
    $updateQuery = "UPDATE orders SET orderStatus = 2 WHERE orderId = $orderId AND orderStatus = 1"; // Chỉ cập nhật nếu trạng thái hiện tại là "Chờ xác nhận"
    if (mysqli_query($conn, $updateQuery)) {
        echo "Trạng thái đơn hàng đã được cập nhật thành 'Đang xử lý'.";
    } else {
        echo "Lỗi khi cập nhật trạng thái đơn hàng.";
    }
    header("Location: order.php"); // Reload lại trang sau khi cập nhật
    exit();
}
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bộ lọc danh sách đơn hàng</h4>
                        <form method="GET" action="" class="row g-3">
                            <!-- Tỉnh/Thành -->
                            <div class="col-md-3 p-2">
                                <label for="province" class="form-label">Tỉnh/Thành</label>
                                <select name="province" id="province" class="form-select p-2">
                                    <option value="">Tất cả</option>
                                </select>
                            </div>

                            <!-- Quận/Huyện -->
                            <div class="col-md-3">
                                <label for="district" class="form-label">Quận/Huyện</label>
                                <select name="district" id="district" class="form-select p-2">
                                    <option value="">Tất cả</option>
                                </select>
                            </div>

                            <!-- Phường/Xã -->
                            <div class="col-md-3">
                                <label for="ward" class="form-label">Phường/Xã</label>
                                <select name="ward" id="ward" class="form-select p-2">
                                    <option value="">Tất cả</option>
                                </select>
                            </div>


                            <!-- Lọc theo tình trạng đơn hàng -->
                            <div class="col-md-3">
                                <label for="orderStatus" class="form-label">Tình trạng đơn hàng</label>
                                <select name="orderStatus" id="orderStatus" class="form-select p-2">
                                    <option value="">Tất cả</option>
                                    <option value="1" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == '1' ? 'selected' : ''; ?>>
                                        Chờ xác nhận</option>
                                    <option value="2" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == '2' ? 'selected' : ''; ?>>
                                        Đang xử lý</option>
                                    <option value="3" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == '3' ? 'selected' : ''; ?>>
                                        Đang giao hàng</option>
                                    <option value="4" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == '4' ? 'selected' : ''; ?>>
                                        Hoàn thành</option>
                                    <option value="5" <?= isset($_GET['orderStatus']) && $_GET['orderStatus'] == '5' ? 'selected' : ''; ?>>
                                        Đã hủy</option>
                                </select>
                            </div>

                            <!-- Lọc theo khoảng thời gian -->
                            <div class="col-md-3">
                                <label for="startDate" class="form-label">Từ ngày</label>
                                <input type="date" name="startDate" id="startDate" class="form-control"
                                    value="<?= isset($_GET['startDate']) ? $_GET['startDate'] : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="endDate" class="form-label">Đến ngày</label>
                                <input type="date" name="endDate" id="endDate" class="form-control"
                                    value="<?= isset($_GET['endDate']) ? $_GET['endDate'] : ''; ?>">
                            </div>
                            <!-- Nút lọc -->
                            <div class="col-md-3 d-flex align-items-center justify-content-between">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary">Lọc</button>
                                <a href="order.php" class="btn btn-secondary">Xóa lọc</a>
                            </div>
                        </form>
                    </div>
                    <h5 class="card-header d-flex align-items-center justify-content-between">Danh sách đơn hàng</h5>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Phương thức</th>
                                    <th>Địa chỉ</th>
                                    <th>Khách hàng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Lấy các giá trị lọc từ form
                                $orderStatus = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : '';
                                $province = isset($_GET['province']) ? $_GET['province'] : '';
                                $district = isset($_GET['district']) ? $_GET['district'] : '';
                                $ward = isset($_GET['ward']) ? $_GET['ward'] : '';
                                $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
                                $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

                                // Xây dựng truy vấn SQL với các điều kiện lọc
                                $query = "SELECT o.*, u.userName FROM orders o 
                                        LEFT JOIN users u ON o.userId = u.userId 
                                        WHERE 1=1"; // Điều kiện mặc định
                                
                                if (!empty($orderStatus)) {
                                    $query .= " AND o.orderStatus = '$orderStatus'";
                                }

                                if (!empty($startDate)) {
                                    $query .= " AND o.create_at >= '{$startDate} 00:00:00'";
                                }

                                if (!empty($endDate)) {
                                    $query .= " AND o.create_at <= '{$endDate} 23:59:59'";
                                }
                                if (!empty($province) && isset($provinceNameToCode[$province])) {
                                    $provinceCode = $provinceNameToCode[$province];
                                    $query .= " AND o.orderCity = '$provinceCode'";
                                }
                                if (!empty($district) && isset($districtNameToCode[$district])) {
                                    $districtCode = $districtNameToCode[$district];
                                    $query .= " AND o.orderDistrict = '$districtCode'";
                                }
                                if (!empty($ward) && isset($wardNameToCode[$ward])) {
                                    $wardCode = $wardNameToCode[$ward];
                                    $query .= " AND o.orderWard = '$wardCode'";
                                }


                                $query .= " ORDER BY o.create_at DESC";

                                // Thêm LIMIT và OFFSET sau khi $query được khởi tạo
                                
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?= $row['orderId']; ?></td>
                                            <td><?= number_format($row['orderPrice'], 0, ',', '.'); ?> VND</td>
                                            <td>
                                                <?php
                                                switch ($row['orderStatus']) {
                                                    case 1:
                                                        echo '<span class="badge bg-warning">Chờ xác nhận</span>';
                                                        break;
                                                    case 2:
                                                        echo '<span class="badge bg-info">Đang xử lý</span>';
                                                        break;
                                                    case 3:
                                                        echo '<span class="badge bg-success">Đang giao hàng</span>';
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
                                            </td>
                                            <td><?= $row['create_at']; ?></td>
                                            <td>
                                                <?= $row['orderMethod'] == 1 ? 'Giao tận nơi' : ($row['orderMethod'] == 2 ? 'Nhận tại cửa hàng' : 'Không xác định'); ?>
                                            </td>

                                            <td class="address-cell"
                                                style="max-width: 200px; word-wrap: break-word; white-space: normal;"
                                                data-address="<?= $row['orderAddress'] ?>" data-ward="<?= $row['orderWard']; ?>"
                                                data-district="<?= $row['orderDistrict']; ?>"
                                                data-city="<?= $row['orderCity']; ?>">
                                                Đang tải...
                                            </td>
                                            <td><?= $row['userName']; ?></td>
                                            <td>
                                                <a href="order-detail.php?orderId=<?= $row['orderId']; ?>"
                                                    class="btn btn-info btn-sm">Xem chi tiết</a>
                                                <?php if ($row['orderStatus'] == 1): ?>
                                                    <a href="order.php?confirm_id=<?= $row['orderId']; ?>"
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Xác nhận đơn hàng này?');">Xác nhận</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>Không có đơn hàng nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .card-body {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        table-layout: auto;
        word-break: break-word;
    }

    .table th,
    .table td {
        white-space: nowrap;
        /* Ngăn văn bản xuống dòng không cần thiết */
        text-align: center;
        /* Căn giữa nội dung */
        vertical-align: middle;
    }

    .address-cell {
        white-space: normal !important;
        word-wrap: break-word;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');
        const addressCells = document.querySelectorAll(".address-cell");

        // ===== 1. Tải dữ liệu địa phương từ API =====
        const [provinces, districts, wards] = await Promise.all([
            fetch("https://provinces.open-api.vn/api/p/").then(res => res.json()),
            fetch("https://provinces.open-api.vn/api/d/").then(res => res.json()),
            fetch("https://provinces.open-api.vn/api/w/").then(res => res.json())
        ]);

        // ===== 2. Tạo map từ mã code sang tên =====
        const provinceMap = Object.fromEntries(provinces.map(p => [p.code, p.name]));
        const districtMap = Object.fromEntries(districts.map(d => [d.code, d.name]));
        const wardMap = Object.fromEntries(wards.map(w => [w.code, w.name]));

        // ===== 3. Hiển thị địa chỉ đơn hàng từ mã code sang tên =====
        addressCells.forEach(cell => {
            const address = cell.dataset.address;
            const cityId = cell.dataset.city;
            const districtId = cell.dataset.district;
            const wardId = cell.dataset.ward;

            const cityName = provinceMap[cityId] || '';
            const districtName = districtMap[districtId] || '';
            const wardName = wardMap[wardId] || '';

            const fullAddress = [address, wardName, districtName, cityName].filter(Boolean).join(', ');
            cell.textContent = fullAddress;
            cell.title = fullAddress; // Tooltip khi hover
        });


        // ===== 4. Đổ dữ liệu dropdown tỉnh thành =====
        function loadProvincesDropdown() {
            provinces.forEach(province => {
                const opt = document.createElement('option');
                opt.value = province.name;
                opt.textContent = province.name;
                provinceSelect.appendChild(opt);
            });
        }

        // ===== 5. Đổ dropdown quận huyện khi chọn tỉnh =====
        function loadDistrictsDropdown(provinceName) {
            districtSelect.innerHTML = '<option value="">Tất cả</option>';
            wardSelect.innerHTML = '<option value="">Tất cả</option>';

            const province = provinces.find(p => p.name === provinceName);
            if (!province) return;

            const filteredDistricts = districts.filter(d => d.province_code === province.code);
            filteredDistricts.forEach(district => {
                const opt = document.createElement('option');
                opt.value = district.name;
                opt.textContent = district.name;
                districtSelect.appendChild(opt);
            });
        }

        // ===== 6. Đổ dropdown phường xã khi chọn quận =====
        function loadWardsDropdown(districtName) {
            wardSelect.innerHTML = '<option value="">Tất cả</option>';

            const district = districts.find(d => d.name === districtName);
            if (!district) return;

            const filteredWards = wards.filter(w => w.district_code === district.code);
            filteredWards.forEach(ward => {
                const opt = document.createElement('option');
                opt.value = ward.name;
                opt.textContent = ward.name;
                wardSelect.appendChild(opt);
            });
        }

        // ===== 7. Sự kiện thay đổi dropdown =====
        provinceSelect.addEventListener('change', () => {
            loadDistrictsDropdown(provinceSelect.value);
        });

        districtSelect.addEventListener('change', () => {
            loadWardsDropdown(districtSelect.value);
        });

        // ===== 8. Gọi khi trang tải xong =====
        loadProvincesDropdown();

    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include("../admin/includes/footer.php"); ?>