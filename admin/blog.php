<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3>Bài viết</h3>
                        <a href="add-blog.php" class="btn btn-success">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="ml-1">Thêm</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="blog-cards">
                            <?php
                            $blog = getAll("blogs");

                            if (mysqli_num_rows($blog) > 0) {
                                foreach ($blog as $item) {
                                    ?>
                                    <div class="blog-card">
                                        <div class="blog-info">
                                            <h5>Tiêu đề: <?= $item['blogTitle']; ?></h5>
                                            <img src="../images/<?= $item['blogImage']; ?>" alt="<?= $item['blogTitle']; ?>"
                                                class="blog-image">
                                            <p>Mô tả: <?= $item['blogDescription']; ?></p>
                                            <p>Nội dung: <?= $item['blogContent']; ?></p>
                                            <p class="">Ngày tạo: <?= $item['create_at']; ?></p>
                                            <span class="badge <?= $item['blogStatus'] == '1' ? 'bg-success' : 'bg-danger'; ?>">
                                                <?= $item['blogStatus'] == '1' ? "Đang hiển thị" : "Đã Ẩn"; ?>
                                            </span>
                                            </p>
                                        </div>
                                        <div class="blog-actions d-flex justify-content-center">
                                            <a href="edit-blog.php?blogId=<?= $item['blogId']; ?>" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Sửa</span>
                                            </a>

                                            <form action="code.php" method="POST" class="delete-form">
                                                <input type="hidden" name="blogId" value="<?= $item['blogId']; ?>">
                                                <button type="submit" name="delete_blog_btn" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "No records found";
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
        const items = document.querySelectorAll(".blog-card");
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