<?php include("./includes/header.php"); ?>
<?php

// Truy vấn để lấy mã giảm giá
$query = "SELECT discountId, discountName, discountSlug, discountPercentage
FROM discounts
WHERE NOW() BETWEEN discountStartDate AND discountEndDate;";
$result = $conn->query($query);

// Lưu mã giảm giá vào mảng
$discounts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discounts[] = $row;
    }
}
$conn->close();

$userCity = $_SESSION['auth_user']['userCity'] ?? '';
$userDistrict = $_SESSION['auth_user']['userDistrict'] ?? '';
$userWard = $_SESSION['auth_user']['userWard'] ?? '';
$userAddress = $_SESSION['auth_user']['userAddress'] ?? '';

$userName = $_SESSION['auth_user']['userName'] ?? '';
$userPhone = $_SESSION['auth_user']['userPhone'] ?? '';
$userEmail = $_SESSION['auth_user']['userEmail'] ?? '';

?>

<body>
    <div class="container py-5">
        <div class="row">
            <!-- Thông tin khách hàng -->
            <div class="card col-md-6">
                <div class="card-body">
                    <h3>Thông tin khách hàng</h3>
                    <div class="mb-3">
                        <input type="text" id="user-name" value="<?php echo $userName ?>" required name="user-name"
                            placeholder="Họ và tên" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="user-phone" value="<?php echo $userPhone ?>" required name="user-phone"
                            placeholder="Số điện thoại" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="email" id="user-email" value="<?php echo $userEmail ?>" required name="user-email"
                            placeholder="Email" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Thông tin nhận hàng -->
            <div class="card col-md-6">
                <div class="card-body">
                    <h3>Thông tin nhận hàng</h3>

                    <!-- Chọn hình thức nhận hàng -->
                    <div class="mb-3">
                        <label class="form-label">Hình thức nhận hàng:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="delivery-method" id="delivery-home"
                                    value="1" checked>
                                <label class="form-check-label" for="delivery-home">Giao hàng tận nơi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="delivery-method" id="delivery-store"
                                    value="2">
                                <label class="form-check-label" for="delivery-store">Nhận tại cửa hàng</label>
                            </div>
                        </div>
                    </div>

                    <div class="shipping-home" id="home-delivery-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="city" id="city" class="form-select">
                                    <option value="">Chọn Tỉnh/Thành</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="district" id="district" class="form-select" disabled>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="ward" id="ward" class="form-select" disabled>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="fill-address" value="<?= $userAddress ?>" required
                                    name="fill-address" placeholder="Số nhà, tên đường" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="text" id="note-shipping-home" required name="note-shipping-home"
                                    placeholder="Nhập ghi chú(nếu có)" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Nhận tại cửa hàng -->
                    <div class="shipping-store d-none" id="store-pickup-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="city-store" id="city-store" class="form-select">
                                    <option value="">Chọn Tỉnh/Thành</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="district-store" id="district-store" class="form-select" disabled>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="ward-store" id="ward-store" class="form-select" disabled>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="fill-address-store" id="fill-address-store" class="form-select" disabled>
                                    <option value="">Chọn cửa hàng</option>
                                    <option value="Cửa hàng 1 - 123 Lê Lợi">Cửa hàng 1 - 123 Lê Lợi</option>
                                    <option value="Cửa hàng 2 - 456 Nguyễn Trãi">Cửa hàng 2 - 456 Nguyễn Trãi</option>
                                    <option value="Cửa hàng 3 - 789 Trần Duy Hưng">Cửa hàng 3 - 789 Trần Duy Hưng
                                    </option>
                                    <option value="Cửa hàng 4 - 12 Kim Mã, Ba Đình">Cửa hàng 4 - 12 Kim Mã, Ba Đình
                                    </option>
                                    <option value="Cửa hàng 5 - 99 Hùng Vương, Hải Châu">Cửa hàng 5 - 99 Hùng Vương, Hải
                                        Châu</option>
                                    <option value="Cửa hàng 6 - 88 Nguyễn Văn Cừ">Cửa hàng 6 - 88 Nguyễn Văn Cừ</option>
                                    <option value="Cửa hàng 7 - 23 Lê Thánh Tôn">Cửa hàng 7 - 23 Lê Thánh Tôn</option>
                                    <option value="Cửa hàng 8 - 54 Đại lộ Bình Dương">Cửa hàng 8 - 54 Đại lộ Bình Dương
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="text" id="note-shipping-home" required name="note-shipping-home"
                                    placeholder="Nhập ghi chú(nếu có)" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Giỏ hàng -->
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Giỏ hàng</h3>
                    <ul class="list-group" id="cart-items"></ul>

                    <div class="mb-3">
                        <span>Tạm tính:</span>
                        <span class="float-end" id="subtotal">0 VND</span>
                    </div>
                    <div class="mb-3">
                        <span>Tổng tiền: </span>
                        <span id="total-price" class="float-end">0 VND</span>
                    </div>
                    <!-- Phần mã giảm giá -->
                    <div class="mb-3">
                        <label for="discount-code" class="form-label">Mã giảm giá:</label>
                        <div class="d-flex">
                            <select id="discount-code" class="form-select me-2">
                                <option value="">Chọn mã giảm giá</option>
                                <?php foreach ($discounts as $discount): ?>
                                    <option value=<?php echo $discount['discountPercentage']; ?> data-discount-id=<?php echo $discount['discountId']; ?>>
                                        <?php echo $discount['discountName'] . ' - Giảm ' . $discount['discountPercentage'] . '%'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-primary" id="apply-discount">Áp dụng</button>
                        </div>
                        <span class="text-danger" id="discount-message"></span>
                    </div>
                    <button class="btn btn-primary w-100" id="checkout-btn" type="button">Thanh toán</button>
                </div>
            </div>
        </div>

        <!-- Modal chọn phương thức thanh toán -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chọn phương thức thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment-method" id="cod" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment-method" id="banking">
                            <label class="form-check-label" for="banking">Chuyển khoản ngân hàng</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment-method" id="momo">
                            <label class="form-check-label" for="momo">Thanh toán qua ví Momo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-success" id="confirm-payment-btn">Xác nhận thanh
                            toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Nếu chọn giao hàng tận nơi thì hiển thị 63 tỉnh thành tương ứng
            const selectedCity = "<?= $userCity ?>";
            const selectedDistrict = "<?= $userDistrict ?>";
            const selectedWard = "<?= $userWard ?>";

            const citySelect = document.getElementById("city");
            const districtSelect = document.getElementById("district");
            const wardSelect = document.getElementById("ward");

            const deliveryRadios = document.querySelectorAll('input[name="delivery-method"]');
            const homeSection = document.getElementById("home-delivery-section");
            const storeSection = document.getElementById("store-pickup-section");

            deliveryRadios.forEach(radio => {
                radio.addEventListener("change", function () {
                    if (this.value == "1") {
                        homeSection.classList.remove("d-none");
                        storeSection.classList.add("d-none");
                        // Giao hàng tận nơi
                    } else {
                        homeSection.classList.add("d-none");
                        storeSection.classList.remove("d-none");
                        // Nhận tại cửa hàng (không có selected sẵn)
                    }
                });
            });

            setupAddressSelects("city", "district", "ward", selectedCity, selectedDistrict, selectedWard);
            setupAddressSelects("city-store", "district-store", "ward-store", null, null, null, "fill-address-store");

            /// Thiết lập dropdown cho địa chỉ
            function setupAddressSelects(cityId, districtId, wardId, selectedCity, selectedDistrict, selectedWard, storeAddressId) {
                const citySelect = document.getElementById(cityId);
                const districtSelect = document.getElementById(districtId);
                const wardSelect = document.getElementById(wardId);
                const storeAddressSelect = document.getElementById(storeAddressId);

                fetch("https://provinces.open-api.vn/api/")
                    .then(res => res.json())
                    .then(provinces => {
                        provinces.forEach(province => {
                            const option = document.createElement("option");
                            option.value = province.code;
                            option.textContent = province.name;
                            if (province.code == selectedCity) {
                                option.selected = true;
                                loadDistricts(province.code);
                            }
                            citySelect.appendChild(option);
                        });
                    });

                function loadDistricts(cityCode) {
                    fetch(`https://provinces.open-api.vn/api/p/${cityCode}?depth=2`)
                        .then(res => res.json())
                        .then(data => {
                            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                            data.districts.forEach(district => {
                                const option = document.createElement("option");
                                option.value = district.code;
                                option.textContent = district.name;
                                if (district.code == selectedDistrict) {
                                    option.selected = true;
                                    loadWards(district.code);
                                }
                                districtSelect.appendChild(option);
                            });
                            districtSelect.disabled = false;
                        });
                }

                function loadWards(districtCode) {
                    fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                        .then(res => res.json())
                        .then(data => {
                            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                            data.wards.forEach(ward => {
                                const option = document.createElement("option");
                                option.value = ward.code;
                                option.textContent = ward.name;
                                if (ward.code == selectedWard) {
                                    option.selected = true;
                                }
                                wardSelect.appendChild(option);
                            });
                            wardSelect.disabled = false;
                        });
                }

                citySelect.addEventListener("change", () => {
                    const cityCode = citySelect.value;
                    districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                    districtSelect.disabled = true;
                    wardSelect.disabled = true;

                    if (cityCode) loadDistricts(cityCode);
                });

                districtSelect.addEventListener("change", () => {
                    const districtCode = districtSelect.value;
                    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                    wardSelect.disabled = true;

                    if (districtCode) loadWards(districtCode);
                });

                // Khi chọn phường thì cho phép chọn cửa hàng
                wardSelect.addEventListener("change", function () {
                    if (this.value) {
                        storeAddressSelect.disabled = false;
                    } else {
                        storeAddressSelect.disabled = true;
                        storeAddressSelect.selectedIndex = 0;
                    }
                });
            }
        });

        const authUser = <?php echo json_encode($_SESSION['auth_user'] ?? []); ?>;
        if (!authUser.userId) {
            location.href = './login.php';
        }
    </script>
    <script src="./assets/js/cart.js"></script>
</body>
<?php include("./includes/footer.php"); ?>