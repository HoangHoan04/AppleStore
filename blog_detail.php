<?php
include("./includes/header.php");

if (isset($_GET['blogId'])) {
    $blogId = intval($_GET['blogId']);
    $query = "SELECT * FROM blogs WHERE blogId = $blogId AND blogStatus = 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $blog = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Bài viết không tồn tại</p>";
        exit;
    }
} else {
    echo "<p>Không tìm thấy bài viết</p>";
    exit;
}
?>

<div class="blog-container">
    <h1 class="blog-title text-center"><?php echo $blog['blogTitle']; ?></h1>
    <img src="./images/<?php echo $blog['blogImage']; ?>" alt="<?php echo $blog['blogTitle']; ?>" class="blog-image">
    <p class="blog-description"><?php echo $blog['blogDescription']; ?></p>
    <div class="blog-content"><?php echo nl2br($blog['blogContent']); ?></div>
    <div class="separator"></div> <!-- Kẻ ngang -->
    <div class="blogs-more">
        <h2 class="section-title m-5 text-center">Các bài viết khác</h2>
        <div class="blog-carousel">
            <?php
            // Lấy danh sách blog từ database
            $blogs = getBlogAllActive("blogs");
            if (mysqli_num_rows($blogs) > 0) {
                while ($blog = mysqli_fetch_assoc($blogs)) {
                    echo '<div class="blog-carousel-item">';
                    echo '<a href="blog_detail.php?blogId=' . $blog['blogId'] . '" class="blog-link">';
                    echo '<div class="blog-carousel-image">';
                    echo '<img class="blog-carousel-image" src="./images/' . $blog['blogImage'] . '" alt="' . $blog['blogTitle'] . '">';
                    echo '</div>';
                    echo '<div class="blog-carousel-content">';
                    echo '<h3 class="blog-carousel-title">' . htmlspecialchars($blog['blogTitle']) . '</h3>';
                    echo '<p class="blog-carousel-excerpt">' . htmlspecialchars(substr($blog['blogContent'], 0, 100)) . '...</p>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-blogs">Không có bài viết nào.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const itemsPerPage = 4;
        const blogCards = document.querySelectorAll(".blog-carousel-item");
        const container = document.querySelector(".blog-carousel");

        let currentPage = 1;
        const totalPages = Math.ceil(blogCards.length / itemsPerPage);

        function showPage(page) {
            blogCards.forEach((card, index) => {
                card.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? "block" : "none";
            });
        }

        function createPagination() {
            const pagination = document.createElement("div");
            pagination.className = "pagination";

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.innerText = i;
                btn.className = "pagination-btn";
                if (i === currentPage) btn.classList.add("active");

                btn.addEventListener("click", () => {
                    currentPage = i;
                    showPage(currentPage);
                    document.querySelectorAll(".pagination-btn").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                });

                pagination.appendChild(btn);
            }

            container.after(pagination);
        }

        showPage(currentPage);
        if (blogCards.length > itemsPerPage) createPagination();
    });
</script>


<style>
    .blog-container {
        max-width: 100%;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .blog-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 10px;
    }

    .blog-title {
        font-size: 2rem;
        color: #333;
        margin-top: 15px;
    }

    .blog-description {
        font-size: 1.2rem;
        color: #666;
        margin-top: 10px;
    }

    .blog-content {
        font-size: 1rem;
        color: #444;
        margin-top: 15px;
        line-height: 1.6;
    }

    .blog-carousel {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        /* Hiển thị 4 cột trên mỗi dòng */
        gap: 20px;
        /* Khoảng cách giữa các bài viết */
        margin-top: 20px;
        padding-bottom: 20px;
    }

    .blog-carousel-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }

    .blog-carousel-item:hover {
        transform: translateY(-5px);
    }

    .blog-carousel-image img {
        width: 100%;
        height: 100px;
        object-fit: contain;
        display: block;
    }

    .blog-carousel-content {
        padding: 12px;
    }

    .blog-carousel-title {
        font-size: 1.1rem;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .blog-carousel-excerpt {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }

    .blog-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    /* Responsive Design: Khi màn hình nhỏ hơn 1024px, hiển thị 2 bài viết trên 1 dòng */
    @media (max-width: 1024px) {
        .blog-carousel {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Responsive Design: Khi màn hình nhỏ hơn 768px, hiển thị 1 bài viết trên mỗi dòng */
    @media (max-width: 768px) {
        .blog-carousel {
            grid-template-columns: 1fr;
        }
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-top: 20px;
    }

    .pagination-btn {
        padding: 6px 12px;
        margin: 0 5px;
        border: none;
        background-color: #eee;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .pagination-btn.active,
    .pagination-btn:hover {
        background-color: orangered;
        color: #fff;
    }

    .blog-card {
        margin-bottom: 20px;
    }

    .separator-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .content-before,
    .content-after {
        margin: 10px 0;
        font-size: 1rem;
        color: #333;
    }

    .separator {
        border-top: 2px solid #ccc;
        /* Kẻ đường ngang */
        margin: 20px 0;
    }
</style>