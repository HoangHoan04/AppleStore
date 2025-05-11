<?php
include("../admin/includes/header.php");

function fetchAddressName($type, $id, $districtId = null)
{
    if ($type === 'w') {
        // Lấy danh sách wards từ quận
        if (!$districtId)
            return null;
        $url = "https://provinces.open-api.vn/api/d/$districtId?depth=2";
        $data = @file_get_contents($url);
        if ($data === false)
            return null;
        $json = json_decode($data, true);
        if (!isset($json['wards']))
            return null;

        foreach ($json['wards'] as $ward) {
            if ($ward['code'] == $id) {
                return $ward['name'];
            }
        }
        return null;
    } else {
        $url = "https://provinces.open-api.vn/api/$type/$id";
        $data = @file_get_contents($url);
        if ($data === false)
            return null;
        $json = json_decode($data, true);
        return $json['name'] ?? null;
    }
}


?>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3>Người dùng</h3>
                    </div>
                    <div class="card-body">
                        <div class="user-cards">
                            <?php
                            $users = getAll("users");
                            if (mysqli_num_rows($users) > 0) {
                                foreach ($users as $item) {
                                    $cityName = $item['userCity'] ? fetchAddressName('p', $item['userCity']) : '[Không tải được tỉnh]';
                                    $districtName = $item['userDistrict'] ? fetchAddressName('d', $item['userDistrict']) : '[Không tải được quận]';
                                    $wardName = $item['userWard'] ? fetchAddressName('w', $item['userWard'], $item['userDistrict']) : '[Không tải được phường]';
                                    $userImage = !empty($item['userImage']) ? $item['userImage'] : "userImageDefault.png";

                                    ?>
                                    <div class="user-card align-items-center justify-content-between p-3 mb-3 border rounded">
                                        <div class="user-info d-flex align-items-center">
                                            <div class="user-image me-3">
                                                <img src="../images/<?= $userImage; ?>" width="100px" height="100px"
                                                    class="rounded-circle" alt="User Image">
                                            </div>
                                            <div>
                                                <h5>Họ tên: <?= $item['userName']; ?></h5>
                                                <p class="text-muted">Email: <?= $item['userEmail']; ?></p>
                                                <p class="text-muted">
                                                    Địa chỉ: <?= $item['userAddress']; ?>,<?= $wardName ?>,
                                                    <?= $districtName ?>, <?= $cityName ?>
                                                </p>
                                                <p class="text-muted">Điện thoại: <?= $item['userPhone']; ?></p>
                                                <p class="">Ngày tạo tài khoản: <?= $item['create_at']; ?></p>
                                                <span
                                                    class="badge <?= $item['userStatus'] == '1' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?= $item['userStatus'] == '1' ? "Đang hoạt động" : "Đã khóa"; ?>
                                                </span>
                                                <?php if ($item['userRole'] == 4): ?>
                                                    <span class="badge bg-primary ms-2">Admin</span>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <div class="user-actions">
                                            <a href="edit-user.php?userId=<?= $item['userId']; ?>" class="mb-0 btn btn-info ">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Sửa thông tin</span>
                                            </a>
                                            <form action="code.php" method="POST">
                                                <input type="hidden" name="userId" value="<?= $item['userId']; ?>">
                                                <button type="submit" name="resetpassword_user_btn" class="btn btn-success">
                                                    <i class="fa-solid fa-repeat"></i>
                                                    Đặt lại mật khẩu
                                                </button>
                                            </form>
                                            <form action="code.php" method="POST">
                                                <input type="hidden" name="userId" value="<?= $item['userId']; ?>">
                                                <button type="submit" name="lock_user_btn"
                                                    class="m-0 w-100 <?= ($item['userStatus'] == 1) ? 'btn-lock' : 'btn-unlock' ?>">
                                                    <i class="fa-solid fa-lock"></i>
                                                    <?= ($item['userStatus'] == 1) ? 'Khóa' : 'Mở khóa' ?>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p class='text-center'>Không có người dùng nào</p>";
                            }
                            ?>
                        </div>

                    </div>
                    <div class="pagination mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const itemsPerPage = 6;
        const items = document.querySelectorAll(".user-card");
        const paginationContainer = document.querySelector(".pagination");

        let currentPage = 1;
        const totalPages = Math.ceil(items.length / itemsPerPage);

        function showPage(page) {
            items.forEach((item, index) => {
                item.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? "flex" : "none";
            });
        }

        function renderPagination() {
            paginationContainer.innerHTML = "";

            // Nút < (Previous)
            const prevBtn = document.createElement("button");
            prevBtn.innerHTML = "&laquo;";
            prevBtn.className = "btn btn-sm btn-outline-primary";
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    renderPagination();
                }
            });
            paginationContainer.appendChild(prevBtn);

            // Các nút số trang
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = "btn btn-sm btn-outline-primary";
                if (i === currentPage) btn.classList.add("active");
                btn.addEventListener("click", () => {
                    currentPage = i;
                    showPage(currentPage);
                    renderPagination();
                });
                paginationContainer.appendChild(btn);
            }

            // Nút > (Next)
            const nextBtn = document.createElement("button");
            nextBtn.innerHTML = "&raquo;";
            nextBtn.className = "btn btn-sm btn-outline-primary";
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener("click", () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                    renderPagination();
                }
            });
            paginationContainer.appendChild(nextBtn);
        }

        showPage(currentPage);
        renderPagination();
    });
</script>
<style>
    .badge.bg-primary {
        color: white;
        background-color: #ffcc00 !important;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    .user-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .btn-lock {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-unlock {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-reset {
        background-color: rgb(184, 220, 53);
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .pagination button {
        padding: 6px 12px;
        font-size: 14px;
        border: 1px solid rgb(151, 14, 14);
        background-color: white;
        color: red;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination button:hover:not(:disabled) {
        background-color: red;
        color: white;
    }

    .pagination button.active {
        background-color: orangered;
        color: white;
        font-weight: bold;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
<?php include("../admin/includes/footer.php"); ?>