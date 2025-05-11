<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['userId'])) {
                    $userId = $_GET['userId'];
                    $user = getByIdUser("users", $userId);

                    if (mysqli_num_rows($user) > 0) {
                        $data = mysqli_fetch_array($user);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa thông tin người dùng</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="userId" value="<?= $data['userId'] ?>">
                                            <label for=""><b>Tên người dùng</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['userName'] ?>"
                                                name="userName" placeholder="Nhập vào tên" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label for=""><b>Email</b></label>
                                            <input type="text" id="slug-name" required value="<?= $data['userEmail'] ?>"
                                                name="userEmail" placeholder="Nhập vào email" class="form-control">
                                        </div>
                                        <div class="col-md-24">
                                            <label for=""><b>Số điện thoại</b></label>
                                            <input type="text" required value="<?= $data['userPhone'] ?>" name="userPhone"
                                                placeholder="Nhập vào số điện thoại" class="form-control">
                                        </div>

                                        <div class="col-md-24">
                                            <label for=""><b>Ảnh đại diện</b></label><br>
                                            <input type="file" name="userImage" id="userImage" class="form-control mb-2"
                                                accept="image/*">
                                            <img src="../images/<?= $data['userImage'] ?>" id="previewImage" alt="Ảnh xem trước"
                                                width="120" class="mt-2"
                                                style="display:block; border:1px solid #ccc; padding: 5px;">
                                        </div>

                                        <div class="col-md-6">
                                            <label for=""><b>Thành phố/Tỉnh</b></label>
                                            <select name="userCity" id="city" required class="form-select p-2">
                                                <option value="">Chọn Tỉnh/Thành</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>Quận/Huyện</b></label>
                                            <select name="userDistrict" id="district" required class="form-select p-2" disabled>
                                                <option value="">Chọn Quận/Huyện</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>Xã/Phường</b></label>
                                            <select name="userWard" id="ward" required class="form-select p-2" disabled>
                                                <option value="">Chọn Phường/Xã</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>Thôn/Xóm/Làng/Ấp</b></label>
                                            <input type="text" id="fill-address" value="<?= $data['userAddress'] ?>" required
                                                name="userAddress" placeholder="Số nhà, tên đường" class="form-control">
                                        </div>
                                        <div class="col-md-24">
                                            <label><b>Trạng thái</b></label>
                                            <label class="switch">
                                                <input type="checkbox" <?= $data['userStatus'] ? "checked" : "" ?>
                                                    name="userStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" name="update_info_user_btn">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "user not found";
                    }
                } else {
                    echo "Id missing from URL";
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById("userImage").addEventListener("change", function () {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById("previewImage");
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    });
</script>


<script>


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
</script>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>