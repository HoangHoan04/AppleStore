<?php
include("./includes/header.php");

if (!isset($_SESSION['auth_user']['userId'])) {
    die("Từ chối truy cập");
}

$userId = $_SESSION['auth_user']['userId'];
$users = getUserByID("users", $userId);
$data = mysqli_fetch_array($users);
?>

<body>
    <!-- end header -->
    <div class="user-profile-wrapper">
        <div class="user-profile-page">
            <div class="user-profile-left">
                <!-- Hiển thị ảnh đại diện -->
                <div class="profile-image">
                    <img id="previewImage"
                        src="./images/<?= !empty($data['userImage']) ? $data['userImage'] : 'userImageDefault.png' ?>"
                        alt="Ảnh đại diện" class="img-thumbnail" style=" object-fit: cover;">
                </div>
                <label for="fileUpload" class="custom-file-upload">
                    Tải lên ảnh
                </label>

            </div>

            <div class="user-profile-right">
                <h3 class="page-title">Trang cá nhân</h3>
                <form action="./functions/authcode.php" method="POST" enctype="multipart/form-data">
                    <label class="mb-0" for=""><b>Họ và tên</b></label>
                    <input class="form-control" required type="text" name="userName"
                        value="<?= $data['userName'] ?>"><br>

                    <label class="mb-0" for=""><b>Email</b></label>
                    <input readonly class="form-control" required type="text" name="userEmail"
                        value="<?= $data['userEmail'] ?>"><br>

                    <label class="mb-0" for=""><b>Số điện thoại</b></label>
                    <input class="form-control" required type="text" name="userPhone"
                        value="<?= $data['userPhone'] ?>"><br>

                    <label class="mb-0" for=""><b>Địa chỉ</b></label>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="userCity" id="city" required class="form-select">
                                <option value="">Chọn Tỉnh/Thành</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="userDistrict" id="district" required class="form-select" disabled>
                                <option value="">Chọn Quận/Huyện</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="userWard" id="ward" required class="form-select" disabled>
                                <option value="">Chọn Phường/Xã</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="fill-address" value="<?= $data['userAddress'] ?>" required
                                name="userAddress" placeholder="Số nhà, tên đường" class="form-control">
                        </div>
                    </div>

                    <label class="mb-0" for=""><b>Mật khẩu</b></label>
                    <input class="form-control" type="password" name="userPassword"><br>

                    <label class="mb-0" for=""><b>Xác nhận mật khẩu</b></label>
                    <input class="form-control" type="password" name="userCofirmPassword"><br>

                    <!-- Thêm trường tải ảnh -->
                    <input type="file" id="fileUpload" class="form-control-file" name="userImage" accept="image/*">

                    <input type="hidden" name="update_user_btn" value="true">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('fileUpload').addEventListener('change', function (event) {
        const file = event.target.files[0]; // Lấy file từ input
        if (file) {
            const reader = new FileReader(); // Tạo FileReader để đọc dữ liệu file
            reader.onload = function (e) {
                const previewImage = document.getElementById('previewImage'); // Lấy thẻ <img> để hiển thị
                previewImage.src = e.target.result; // Cập nhật thuộc tính src của thẻ <img>
            };
            reader.readAsDataURL(file); // Đọc file và chuyển sang dạng URL
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const selectedCity = "<?= $data['userCity'] ?>";
        const selectedDistrict = "<?= $data['userDistrict'] ?>";
        const selectedWard = "<?= $data['userWard'] ?>";

        const citySelect = document.getElementById("city");
        const districtSelect = document.getElementById("district");
        const wardSelect = document.getElementById("ward");

        // Load danh sách tỉnh thành và trigger district/ward nếu có sẵn dữ liệu
        fetch("https://provinces.open-api.vn/api/")
            .then(res => res.json())
            .then(provinces => {
                provinces.forEach(province => {
                    const option = document.createElement("option");
                    option.value = province.code;
                    option.textContent = province.name;
                    if (province.code == selectedCity) {
                        option.selected = true;
                        loadDistricts(province.code); // Gọi district
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
                            loadWards(district.code); // Gọi ward
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

        // Khi người dùng chọn tỉnh/thành
        citySelect.addEventListener("change", function () {
            const cityCode = this.value;
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            districtSelect.disabled = true;
            wardSelect.disabled = true;

            if (cityCode) {
                loadDistricts(cityCode);
            }
        });

        // Khi người dùng chọn quận/huyện
        districtSelect.addEventListener("change", function () {
            const districtCode = this.value;
            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            wardSelect.disabled = true;

            if (districtCode) {
                loadWards(districtCode);
            }
        });
    })
</script>

<?php include("./includes/footer.php") ?>