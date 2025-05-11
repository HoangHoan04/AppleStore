<?php
include("./includes/header.php");

// $categoryName = isset($_GET['type']) ? $_GET['type'] : '';

// $products = [];
// if (!empty($categoryName)) {
//     $query = "SELECT p.*, c.categoryImage, c.categoryId FROM products p 
//               JOIN categories c ON p.categoryId = c.categoryId 
//               WHERE c.categoryName = ? AND p.productStatus = 1";
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
// } else {
//     $query = "SELECT * FROM products WHERE productStatus = 1";
//     $result = mysqli_query($conn, $query);
//     $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
// }
?>
<style>
    .category-section {
        text-align: center;
        margin: 40px 0;
    }

    /* Logo danh mục */
    .category-logo {
        max-width: 120px;
        height: auto;
        margin-bottom: 15px;
        font-size: 25px;
        margin: auto;
        font-weight: bolder;
    }

    /* Container carousel */
    .carousel {
        position: relative;
        max-width: 1400px;
        margin: auto;
        overflow: hidden;
        padding: 20px 0;
    }

    /* Dải chứa các item trong carousel */
    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
        width: 100%;
    }

    /* Mỗi item của carousel */
    .carousel-item {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        min-width: 100%;
        padding: 20px;
    }

    /* Nhóm các card */
    .card-deck {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Định dạng card sản phẩm */
    .card {
        flex: 1;
        max-width: 280px;
        height: 500px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Định dạng hình ảnh sản phẩm */
    .card-image {
        padding: 20px;
        width: 100%;
        height: 380px;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover .card-image img {
        transform: scale(1.08);
    }

    /* Nội dung sản phẩm */
    .card-body {
        padding: 15px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Tiêu đề sản phẩm */
    .card-title {
        font-size: 18px;
        color: #333;
        margin-bottom: 8px;
    }

    /* Giá sản phẩm */
    .card-text {
        font-size: 16px;
        font-weight: bold;
        color: #e74c3c;
    }

    /* Nút thêm vào giỏ hàng */


    /* Điều chỉnh nút điều khiển carousel */
    .carousel-control-prev,
    .carousel-control-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        z-index: 10;
    }

    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Ẩn những item không phải là active */
    .carousel-item:not(.active) {
        display: none;
    }


    .blogs-section {
        text-align: center;
        margin: 40px 0;
    }

    .blog-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .blog-card {
        max-width: 300px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #fff;
        overflow: hidden;
    }

    .blog-link {
        text-decoration: none;
        color: inherit;
    }

    .blog-image img {
        width: 100%;
        height: 150px;
        object-fit: contain;
        padding: 10px;
    }

    .blog-content {
        padding: 15px;
    }

    .blog-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .blog-excerpt {
        font-size: 14px;
        color: #666;
    }

    .no-blogs {
        font-size: 16px;
        color: #999;
    }
</style>

<style>
    .product-img-fixed {
        height: 300px;
        object-fit: contain;
    }

    .card-best-seller {
        width: 220px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

    }
</style>


<body>
    <!-- Slider -->
    <section>
        <div class="slider-container">
            <?php
            $sliders = getSliderAllActive("sliders");
            if (mysqli_num_rows($sliders) > 0) {
                $slides = [];
                while ($item = mysqli_fetch_assoc($sliders)) {
                    $image = $item['sliderImage'];
                    $title = $item['sliderTitle'];
                    $slides[] = ['image' => $image, 'title' => $title];
                }
                foreach ($slides as $index => $slide) {
                    echo "<div class='slide' id='slide-" . ($index + 1) . "'>";
                    if (isset($slide['image']) && isset($slide['title'])) {
                        echo "<img src='./images/" . $slide['image'] . "' alt='" . $slide['title'] . "' class='slide-image'>";
                    } else {
                        echo "<p>Thông tin slider không đầy đủ.</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo '<div class="text-center mt-5">
        <i class="bi bi-emoji-frown display-1 text-secondary"></i>
        <p class="mt-3 text-muted">Không có slider nào để hiển thị.</p>
      </div>';

            }
            ?>
            <a class="prev" onclick="changeSlide(-1)"><i class='bx bx-left-arrow-alt'></i></a>
            <a class="next" onclick="changeSlide(1)"><i class='bx bx-right-arrow-alt'></i></a>
            <div class="dot-container">
                <?php
                if (!empty($slides)) {
                    foreach ($slides as $index => $slide) {
                        echo "<span class='dot' onclick='currentSlide(" . ($index + 1) . ")'></span>";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- box best seller -->
    <section class="bestseller-box-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold">Sản phẩm bán chạy</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-6">
                <?php
                function bestSellers($conn)
                {
                    $query = "
                        SELECT po.productVariantId, SUM(od.orderDetailQuantity) AS quantity, pv.productId, p.productName, pv.productVariantImage, pv.price
                    FROM productorders po
                    JOIN productvariants pv ON po.productVariantId = pv.productVariantId
                    JOIN orderdetails od ON po.orderDetailId = od.orderDetailId
                    JOIN products p ON pv.productId = p.productId
                    WHERE productVariantStatus=1
                    GROUP BY po.productVariantId
                    ORDER BY quantity DESC
                    LIMIT 5
                    ";
                    return $conn->query($query);
                }

                $bestSellers = bestSellers($conn);

                if (mysqli_num_rows($bestSellers) > 0) {
                    while ($product = mysqli_fetch_assoc($bestSellers)) {
                        $originalPrice = round($product['price'] * (1 + rand(10, 20) / 100));
                        $discountPercent = 100 - round($product['price'] / $originalPrice * 100);

                        echo '<div class="col">';
                        echo '<a href="./product_detail.php?productId=' . $product['productId'] . '" class="text-decoration-none text-dark">';
                        echo '<div class="card-best-seller h-100 shadow-sm border-0 rounded-4 position-relative">';

                        // Ribbon giảm giá
                        echo '<span class="position-absolute top-0 start-0 badge bg-danger text-white rounded-start rounded-bottom px-2 py-1" style="z-index:1; font-size: 0.8rem;">-' . $discountPercent . '%</span>';

                        echo '<img src="./images/' . htmlspecialchars($product['productVariantImage']) . '" class="card-img-top rounded-top-4 product-img-fixed" alt="' . htmlspecialchars($product['productName']) . '">';

                        echo '<div class="card-body text-center">';
                        echo '<h6 class="card-title fw-semibold text-truncate">' . htmlspecialchars($product['productName']) . '</h6>';

                        // Giá
                        echo '                  <span style="white-space: nowrap;">';
                        echo '                      <span class="text-danger fw-bold">' . number_format($product['price'], 0, ',', '.') . '₫</span> ';
                        echo '                      <small class="text-muted text-decoration-line-through">' . number_format($originalPrice, 0, ',', '.') . '₫</small>';
                        echo '                  </span>';

                        // Lượt bán
                        echo '<p class="text-muted small mb-0">' . number_format($product['quantity']) . ' lượt bán</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Không có sản phẩm bán chạy</p>';
                }
                ?>
            </div>
        </div>
    </section>


    <!-- box category -->
    <section class="category-box-section">
        <nav class="nav-container">
            <div class="category-grid">
                <?php
                $categories = getCategoryAllActive("categories");
                if (mysqli_num_rows($categories) > 0) {
                    while ($item = mysqli_fetch_assoc($categories)) {
                        echo '<a href="./product.php?type=' . urlencode($item['categoryName']) . '" class="category-item">';
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

    <!-- Product -->
    <section class="products-section">
        <?php
        if (mysqli_num_rows($categories) > 0) {
            mysqli_data_seek($categories, 0);
            while ($category = mysqli_fetch_assoc($categories)) {
                $categoryId = $category['categoryId'];
                $categoryName = $category['categoryName'];
                $categoryLogo = $category['categoryLogo'];

                // Truy vấn lấy sản phẩm của mỗi category
                $query = "SELECT p.productId, p.productName, pv.productVariantImage, pv.price
              FROM products p
              LEFT JOIN productvariants pv ON p.productId = pv.productId
              WHERE p.categoryId = ? AND p.productStatus = 1"; // Lấy sản phẩm đang hoạt động
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $categoryId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $uniqueProducts = [];

                if (!empty($products)) {
                    foreach ($products as $product) {
                        if (!in_array($product['productName'], array_column($uniqueProducts, 'productName'))) {
                            $uniqueProducts[] = $product;
                        }
                    }

                    if (!empty($uniqueProducts)) {
                        echo "<section class='category-section'>";

                        echo '<p class="category-logo">' . htmlspecialchars($categoryName) . '</p>';

                        echo "<div id='carousel-{$categoryId}' class='carousel' data-ride='carousel' style='overflow: hidden;'>";
                        echo "<div class='carousel-inner' style='display: flex;'>";

                        $chunks = array_chunk($uniqueProducts, 4); // Mỗi chunk chứa tối đa 4 sản phẩm
                        $numChunks = count($chunks);

                        // Duyệt qua từng nhóm sản phẩm và hiển thị
                        foreach ($chunks as $chunk) {
                            echo "<div class='carousel-item'>";
                            echo "<div class='card-deck' style='display: flex; flex-wrap: nowrap; overflow: hidden;'>";
                            foreach ($chunk as $product) {
                                echo "<div class='card' style='flex: 0 0 auto;'>";
                                echo "<a class='card-item' href='product_detail.php?productId={$product['productId']}'>";
                                echo "<div class='card-image'>";
                                echo "<img src='./images/{$product['productVariantImage']}' alt='{$product['productName']}' class='card-img-top'>";
                                echo "</div>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>{$product['productName']}</h5>";
                                $formattedPrice = number_format($product['price'], 0, ',', '.');
                                echo "<p class='card-text'>{$formattedPrice} VND</p>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }

                        echo "</div>";

                        // Thêm các điều khiển Carousel
                        echo "<a class='carousel-control-prev' href='#carousel-{$categoryId}' role='button' data-slide='prev'>";
                        echo "<i class='bx bx-left-arrow-alt'></i>";
                        echo "</a>";

                        echo "<a class='carousel-control-next' href='#carousel-{$categoryId}' role='button' data-slide='next'>";
                        echo "<i class='bx bx-right-arrow-alt'></i>";
                        echo "</a>";

                        echo "</div>"; // End Carousel
                        echo "</section>";
                    }
                }
            }
        }
        ?>
    </section>


    <!-- Blogs -->
    <section class="blogs-section">
        <h2 class="section-title mb-5">Bài viết mới nhất</h2>
        <div class="blog-container">
            <?php
            // Lấy danh sách blog từ database
            $blogs = getBlogAllActive("blogs");
            if (mysqli_num_rows($blogs) > 0) {
                while ($blog = mysqli_fetch_assoc($blogs)) {
                    echo '<div class="blog-card">';
                    echo '<a href="blog_detail.php?blogId=' . $blog['blogId'] . '" class="blog-link">';
                    echo '<div class="blog-image">';
                    echo '<img src="./images/' . htmlspecialchars($blog['blogImage']) . '" alt="' . htmlspecialchars($blog['blogTitle']) . '">';
                    echo '</div>';
                    echo '<div class="blog-content">';
                    echo '<h3 class="blog-title">' . htmlspecialchars($blog['blogTitle']) . '</h3>';
                    echo '<p class="blog-excerpt">' . htmlspecialchars(substr($blog['blogContent'], 0, 100)) . '...</p>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-blogs">Không có bài viết nào.</p>';
            }
            ?>
        </div>
    </section>
</body>
<?php include("./includes/footer.php"); ?>

<script src="./assets/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousels = document.querySelectorAll(".carousel");

        carousels.forEach((carousel) => {
            let index = 0;
            const items = carousel.querySelectorAll(".carousel-item");
            const totalItems = items.length;
            const prevButton = carousel.querySelector(".carousel-control-prev");
            const nextButton = carousel.querySelector(".carousel-control-next");

            function showSlide(i) {
                items.forEach((item, idx) => {
                    item.classList.toggle("active", idx === i);
                });
            }

            prevButton.addEventListener("click", function () {
                index = (index - 1 + totalItems) % totalItems;
                showSlide(index);
            });

            nextButton.addEventListener("click", function () {
                index = (index + 1) % totalItems;
                showSlide(index);
            });

            showSlide(index);
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const itemsPerPage = 4;
        const blogCards = document.querySelectorAll(".blog-card");
        const container = document.querySelector(".blog-container");

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
</style>