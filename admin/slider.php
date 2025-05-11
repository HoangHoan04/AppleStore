<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3>Slider</h3>
                        <a href="add-slider.php" class="btn btn-success">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="ml-1">Thêm</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="slider-cards">
                            <?php
                            $slider = getAll("sliders");
                            if (mysqli_num_rows($slider) > 0) {
                                foreach ($slider as $item) {
                                    ?>
                                    <div class="slider-card ">
                                        <div class="slider-info d-flex align-items-center">
                                            <div class="slider-image me-3">
                                                <img src="../images/<?= $item['sliderImage']; ?>" width="70px" height="70px"
                                                    alt="<?= $item['sliderTitle']; ?>" class="rounded">
                                            </div>
                                            <div>
                                                <h5 class="mb-1"><?= $item['sliderTitle']; ?></h5>
                                                <p class="mb-1 text-muted"><?= $item['sliderDescription']; ?></p>
                                                <span
                                                    class="badge <?= $item['sliderStatus'] == '1' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?= $item['sliderStatus'] == '1' ? "Đang hiển thị" : "Đã Ẩn"; ?>
                                                </span>
                                                <p class="mt-5">Ngày tạo: <?= $item['createdAt']; ?></p>
                                            </div>
                                        </div>
                                        <div class="slider-actions">
                                            <a href="edit-slider.php?sliderId=<?= $item['sliderId']; ?>"
                                                class="btn btn-primary me-2">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Sửa</span>
                                            </a>
                                            <form action="code.php" method="POST" class="d-inline-block"
                                                id="delete-slider-form">
                                                <input type="hidden" name="sliderId" value="<?= $item['sliderId']; ?>">
                                                <button type="submit" class="btn btn-danger delete-btn" name="delete_slider_btn"
                                                    data-slider-id="<?= $item['sliderId']; ?>">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p class='text-center'>No records found</p>";
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
        const items = document.querySelectorAll(".slider-card");
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
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .slider-card {
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin-bottom: 10px;
    }

    .slider-image img {
        object-fit: cover;
        width: 470px;
        height: auto;
    }

    .slider-info h5 {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .slider-info p {
        font-size: 0.9rem;
    }

    .slider-actions .btn {
        font-size: 0.9rem;
    }

    .slider-actions i {
        margin-right: 5px;
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