<?php
include("./includes/header.php");
?>

<style>
    .blog-container {
        padding: 40px 20px;
        margin: 0 30px;
        background-color: #f9f9f9;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .blog-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .blog-image {
        width: 100%;
        height: 200px;
        object-fit: contain;
        display: block;
    }

    .blog-content {
        padding: 16px 20px;
    }

    .blog-title {
        font-size: 1.25rem;
        color: #333;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .blog-card:hover .blog-title {
        color: #0077cc;
    }
</style>

<body>
    <section class="category-box-section">
        <nav class="nav-container">
            <div class="category-grid">
                <?php
                $categories = getCategoryAllActive("categories");
                if (mysqli_num_rows($categories) > 0) {
                    while ($item = mysqli_fetch_assoc($categories)) {
                        echo '<a href="./blog.php?slug=' . urlencode($item['categorySlug']) . '" class="category-item">';
                        echo '<img src="./images/' . htmlspecialchars($item['categoryImage']) . '" alt="' . htmlspecialchars($item['categoryName']) . '" class="category-image">';
                        echo '<span class="category-label">' . htmlspecialchars($item['categoryName']) . '</span>';
                        echo '</a>';
                    }
                } else {
                    echo '<p>Không có danh mục</p>';
                }
                ?>
            </div>
        </nav>
    </section>

    <div class="blog-container">
        <div class="blog-grid">
            <?php
            if (isset($_GET['slug'])) {
                $slug = urldecode($_GET['slug']);

                // Lấy categoryId từ categorySlug
                $categoryQuery = mysqli_query($conn, "SELECT categoryId FROM categories WHERE categorySlug = '" . mysqli_real_escape_string($conn, $slug) . "' AND categoryStatus = 1");

                if (mysqli_num_rows($categoryQuery) > 0) {
                    $category = mysqli_fetch_assoc($categoryQuery);
                    $categoryId = $category['categoryId'];

                    // Lấy blog theo categoryId
                    $blogs = getBlogsByCategoryId("blogs", $categoryId);
                } else {
                    $blogs = false; // Không có category phù hợp
                }
            } else {
                // Hiển thị tất cả blog nếu không có slug
                $blogs = getBlogAllActive("blogs");
            }

            // Hiển thị blog
            if ($blogs && mysqli_num_rows($blogs) > 0) {
                while ($item = mysqli_fetch_assoc($blogs)) {
                    echo '<div class="blog-card" onclick="window.location.href=\'./blog_detail.php?blogId=' . $item['blogId'] . '\'">';
                    echo '<img src="./images/' . htmlspecialchars($item['blogImage']) . '" alt="' . htmlspecialchars($item['blogTitle']) . '" class="blog-image">';
                    echo '<div class="blog-content">';
                    echo '<h2 class="blog-title">' . htmlspecialchars($item['blogTitle']) . '</h2>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align:center; font-size:1.2rem;">Không có bài viết nào</p>';
            }
            ?>
        </div>
    </div>

    <script src="./assets/js/app.js"></script>
</body>


<?php
include("./includes/footer.php");
?>