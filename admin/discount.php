<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3>Chương trình khuyến mãi</h3>
                        <a href="add-discount.php" class="btn btn-success">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="ml-1">Thêm</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="discount-cards">
                            <?php
                            $discounts = getAll("discounts");

                            if (mysqli_num_rows($discounts) > 0) {
                                foreach ($discounts as $item) {
                                    ?>
                                    <div class="discount-card  justify-content-between mb-4 p-3 border rounded shadow-sm">
                                        <div class="discount-info">
                                            <h5>Tên: <?= $item['discountName']; ?></h5>
                                            <p><strong>Slug:</strong> <?= $item['discountSlug']; ?></p>
                                            <p><strong>Mô tả:</strong> <?= $item['discountDescription']; ?></p>
                                            <p><strong>Phần trăm giảm:</strong>
                                                <?= number_format($item['discountPercentage'], 2, ',', '.'); ?>%</p>
                                            <p><strong>Bắt đầu:</strong>
                                                <?= date('d/m/Y H:i', strtotime($item['discountStartDate'])); ?></p>
                                            <p><strong>Kết thúc:</strong>
                                                <?= date('d/m/Y H:i', strtotime($item['discountEndDate'])); ?></p>
                                            <p><strong>Ngày tạo:</strong>
                                                <?= date('d/m/Y H:i', strtotime($item['create_at'])); ?>
                                            </p>
                                        </div>


                                        <div class="discount-actions mt-2">
                                            <a href="edit-discount.php?discountId=<?= $item['discountId']; ?>"
                                                class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i> Sửa
                                            </a>

                                            <form action="code.php" method="POST" class="d-inline-block delete-form">
                                                <input type="hidden" name="discountId" value="<?= $item['discountId']; ?>">
                                                <button type="submit" name="delete_discount_btn" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p>Không có chương trình giảm giá nào.</p>";
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
        const items = document.querySelectorAll(".discount-card");
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