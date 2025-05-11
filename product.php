<?php
include("./includes/header.php");
$categoryName = isset($_GET['type']) ? $_GET['type'] : '';
$productLineId = isset($_GET['productLineId']) ? $_GET['productLineId'] : '';

$products = [];


// Truy vấn lấy sản phẩm theo categoryName và productLineId
$query = "SELECT p.productId, p.productName, p.productLineId, p.categoryId, p.productStatus, 
                 pv.productVariantImage,pv.productVariantStatus, pv.price, pva.attributeValue, c.categoryImage, c.categoryId,
                 a.attributeName
          FROM products p
          JOIN categories c ON p.categoryId = c.categoryId
          LEFT JOIN productvariants pv ON p.productId = pv.productId
          LEFT JOIN productvariantattributes pva ON pv.productVariantId = pva.productVariantId
          LEFT JOIN attributes a ON pva.attributeId = a.attributeId
          WHERE p.productStatus = 1 AND pv.productVariantStatus = 1";
//   AND a.attributeName = 'Dung lượng'

$params = [];
$types = '';

if (!empty($categoryName)) {
    $query .= " AND c.categoryName = ?";
    $params[] = $categoryName;
    $types .= 's';
}

if (!empty($productLineId)) {
    $query .= " AND p.productLineId = ?";
    $params[] = $productLineId;
    $types .= 's';
}

// Xử lý sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if ($sort === 'price_asc') {
    $query .= " ORDER BY pv.price ASC";
} elseif ($sort === 'price_desc') {
    $query .= " ORDER BY pv.price DESC";
} else {
    $query .= " ORDER BY p.productId DESC"; // Mặc định sắp xếp theo ID sản phẩm mới nhất
}

$stmt = mysqli_prepare($conn, $query);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$productData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['productId'];
    if (!isset($productData[$productId])) {
        $productData[$productId] = [
            'productName' => $row['productName'],
            'productVariantImage' => $row['productVariantImage'],
            'price' => $row['price'],
            'variants' => []
        ];
    }
    $productData[$productId]['variants'][] = [
        'attributeValue' => $row['attributeValue'],
        'price' => $row['price'],
        'image' => $row['productVariantImage']
    ];
}
?>


<div class="product-container">
    <div class="logo-container mb-3">
        <div class="logo-category">
            <?php
            // Lấy dữ liệu slider từ cơ sở dữ liệu
            $logos = getCategoryLogoByCategory($categoryName);
            if (mysqli_num_rows($logos) > 0) {
                while ($logo = mysqli_fetch_assoc($logos)) {
                    echo '<img src="./images/' . $logo['categoryLogo'] . '" alt="Logo">';
                }
            } else {
                echo '<p>AppleStore</p>';
            }
            ?>
        </div>
    </div>

    <div class="app-slider-container">
        <div class="app-slides">
            <?php
            // Lấy dữ liệu slider từ cơ sở dữ liệu
            $slides = getSliderByCategory($categoryName);
            if (mysqli_num_rows($slides) > 0) {
                while ($slide = mysqli_fetch_assoc($slides)) {
                    echo '<div class="app-slide">
                        <img src="./images/' . $slide['sliderImage'] . '" alt="' . $slide['sliderTitle'] . '">
                    </div>';
                }
            } else {
                echo '<div class="d-flex flex-column align-items-center justify-content-center w-100 mt-5">
                        <i class="fa-regular fa-face-sad-tear display-1 text-secondary"></i>
                        <p class="mt-3 text-muted">Không có slider nào để hiển thị.</p>
                    </div>';
            }
            ?>
        </div>

        <div class="app-slider-product-controls">
            <a class="app-slider-product-prev app-slide-product-btn" data-direction="-1">
                <i class='bx bx-left-arrow-alt'></i>
            </a>
            <a class="app-slider-product-next app-slide-product-btn" data-direction="1">
                <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
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


    <div class="filter-product-container">
        <div class="product-line-container">
            <a href="?type=<?= $categoryName ?>">Tất cả</a>
            <?php
            $productLines = getProductLineByCategory($categoryName);
            if (mysqli_num_rows($productLines) > 0) {
                while ($line = mysqli_fetch_assoc($productLines)) {
                    echo '<a href="?type=' . $categoryName . '&productLineId=' . $line['productLineId'] . '">' . $line['productLineName'] . '</a>';
                }
            } else {
                echo '<div class="d-flex flex-column align-items-center justify-content-center w-100 mt-5">
                        <i class="fa-regular fa-face-sad-tear display-1 text-secondary"></i>
                        <p class="mt-3 text-muted">Không có dòng sản phẩm nào để hiển thị.</p>
                    </div>';
            }
            ?>
        </div>
        <div class="sort-dropdown mb-3">
            <select id="sort-select">
                <option value="">Xếp theo: Nổi bật</option>
                <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Giá thấp đến cao</option>
                <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Giá cao đến thấp</option>
            </select>
        </div>

    </div>
    <!-- ================================ -->
    <div class="product-grid">
        <?php foreach ($productData as $productId => $product): ?>
            <div class="product-item">
                <a href="product_detail.php?productId=<?= $productId ?>" class="product-link">
                    <img class="product-image" src="./images/<?= $product['productVariantImage'] ?>"
                        alt="<?= $product['productName'] ?>">
                    <h3 class="product-name"><?= $product['productName'] ?></h3>
                    <p class="product-price">Giá: <?= number_format($product['price'], 0, ',', '.') . '₫'; ?></p>
                </a>

            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <button class="pagination-btn prev-pagination" onclick="changePage(-1)">«</button>
        <div id="page-numbers"></div>
        <button class="pagination-btn next-pagination" onclick="changePage(1)">»</button>
    </div>
</div>

<!-- 
 -->
<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 30px;
        position: relative;
    }

    .pagination-btn {
        background-color: #ffae00;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 8px;
        font-size: 16px;
        color: #fff;
        transition: background 0.3s ease;
    }

    .pagination-btn:hover {
        background-color: #e69500;
    }

    .pagination-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    /* Số trang */
    #page-numbers {
        display: flex;
        gap: 5px;
    }

    .page-number {
        background-color: #fff;
        border: 1px solid #ffae00;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .page-number:hover,
    .page-number.active {
        background-color: #ffae00;
        color: white;
    }

    .product-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 0;
        position: relative;

    }

    .logo-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-category {
        text-align: center;
        background-color: black;
        display: inline-block;
        padding: 10px;
        margin: auto;
        border-radius: 20px;
    }

    .logo-category img {
        max-width: 100%;
        height: auto;
    }

    .app-slider-container {
        position: relative;
        max-width: 100%;
        margin: auto;
        overflow: hidden;
        border-radius: 30px;
    }

    .app-slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .app-slide {
        min-width: 100%;
        transition: transform 0.5s ease-in-out;
    }


    .app-slide img {
        width: 100%;
        display: block;
    }

    .app-slider-product-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
    }

    .app-slider-product-prev,
    .app-slider-product-next {
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        margin: 10px;
        border-radius: 50%;
    }

    .app-slider-product-prev:hover,
    .app-slider-product-next:hover {
        background-color: rgba(0, 0, 0, 0.7);
        text-decoration: none;
        color: #fff;
    }

    .dot-container {
        text-align: center;
        padding: 10px;
    }

    .dot {
        height: 15px;
        width: 15px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .dot:hover {
        background-color: #717171;
    }

    .active {
        background-color: #717171;
    }


    .filter-product-container {
        display: flex;
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        margin: 30px 0 40px;
        flex-wrap: wrap;
        position: relative;
    }

    .filter-product-container a {
        background-color: transparent;
        border: none;
        padding: 10px 15px;
        margin-right: 10px;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }

    .filter-product-container a.active {
        border-bottom: 1px solid #000;
    }

    .product-line-container {
        float: left;
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .product-line-container a:hover {
        border-bottom: 1px solid #fff;
    }

    .sort-dropdown {
        text-align: right;
        float: right;
        position: relative;
        position: absolute;
        min-width: 150px;
        bottom: -35px;
        right: 0;
    }

    .sort-dropdown select {
        border: none;
        padding: 10px;
        border-radius: 5px;
    }

    .sort-dropdown select:active {
        border: none;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }

    .product-item {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-image {
        width: 70%;
        /* Đảm bảo hình ảnh có kích thước đồng đều */
        object-fit: contain;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .product-name {
        font-size: 18px;
        color: #333;
        margin-bottom: 5px;
        padding: 10px;
    }

    .product-price {
        font-size: 18px;
        font-weight: bold;
        color: #ff5722;
    }

    .variant-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .variant-button {
        border: 1px solid #ff5722;
        background: transparent;
        color: #ff5722;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .variant-button:hover {
        background: #ff5722;
        color: white;
    }


    .discount {
        text-decoration: line-through;
        color: gray;
        font-size: 14px;
        margin-left: 5px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const prevBtn = document.querySelector('.app-slider-product-prev');
        const nextBtn = document.querySelector('.app-slider-product-next');
        const slidesContainer = document.querySelector('.app-slides');
        const slides = document.querySelectorAll('.app-slide');
        const dots = document.querySelectorAll('.dot');
        let currentIndex = 0;

        // Hiển thị slide đầu tiên
        function showSlide(index) {
            if (index < 0) {
                currentIndex = slides.length - 1; // Nếu vượt qua đầu, chuyển đến cuối
            } else if (index >= slides.length) {
                currentIndex = 0; // Nếu vượt qua cuối, chuyển về đầu
            }

            // Di chuyển các slide
            slidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

            // Cập nhật các dot
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentIndex].classList.add('active');
        }

        // Di chuyển đến slide trước
        prevBtn.addEventListener('click', function () {
            currentIndex--;
            showSlide(currentIndex);
        });

        // Di chuyển đến slide tiếp theo
        nextBtn.addEventListener('click', function () {
            currentIndex++;
            showSlide(currentIndex);
        });

        // Di chuyển đến slide khi click vào dot
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });

        // Hiển thị slide đầu tiên khi trang được tải
        showSlide(currentIndex);
    });

    document.querySelectorAll('.variant-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation(); // Ngăn chặn sự kiện click lan ra thẻ cha (a)

            let data = JSON.parse(this.getAttribute('data-variant'));
            let productItem = this.closest('.product-item');
            productItem.querySelector('.product-image').src = './images/' + data.image;
            productItem.querySelector('.product-price').textContent = 'Giá: ' +
                new Intl.NumberFormat('vi-VN').format(data.price) + '₫';
        });
    });

    document.getElementById('sort-select').addEventListener('change', function () {
        let url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });

    document.addEventListener("DOMContentLoaded", function () {
        const productsPerPage = 6;
        let currentPage = 1;
        const products = document.querySelectorAll(".product-item");
        const totalPages = Math.ceil(products.length / productsPerPage);
        const pageNumbersContainer = document.getElementById("page-numbers");

        function showPage(page) {
            products.forEach((product, index) => {
                if (index >= (page - 1) * productsPerPage && index < page * productsPerPage) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });

            document.querySelector(".prev-pagination").disabled = page === 1;
            document.querySelector(".next-pagination").disabled = page === totalPages;

            updatePagination(page);
        }

        function updatePagination(activePage) {
            pageNumbersContainer.innerHTML = "";
            for (let i = 1; i <= totalPages; i++) {
                let pageButton = document.createElement("button");
                pageButton.textContent = i;
                pageButton.classList.add("page-number");
                if (i === activePage) {
                    pageButton.classList.add("active");
                }
                pageButton.addEventListener("click", function () {
                    currentPage = i;
                    showPage(currentPage);
                });
                pageNumbersContainer.appendChild(pageButton);
            }
        }

        window.changePage = function (direction) {
            currentPage += direction;
            showPage(currentPage);
        };

        showPage(currentPage);
    });

</script>

<?php include("./includes/footer.php"); ?>