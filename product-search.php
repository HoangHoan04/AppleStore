<?php
include("./includes/header.php");

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
$categoryName = isset($_GET['type']) ? trim($_GET['type']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Trang hiện tại
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$productLine = isset($_GET['productLine']) ? trim($_GET['productLine']) : '';
$priceMin = isset($_GET['price_min']) ? intval($_GET['price_min']) : 0;
$priceMax = isset($_GET['price_max']) ? intval($_GET['price_max']) : 0;
$products = [];

// Xây dựng truy vấn SQL động
$query = "SELECT p.productId, p.productName, p.categoryId, 
                 pv.productVariantImage,pv.productVariantStatus, pv.price, pva.attributeValue, a.attributeName, 
                 c.categoryName
          FROM products p
          LEFT JOIN categories c ON p.categoryId = c.categoryId
          LEFT JOIN productlines pl ON p.productLineId = pl.productLineId
          LEFT JOIN productvariants pv ON p.productId = pv.productId
          LEFT JOIN productvariantattributes pva ON pv.productVariantId = pva.productVariantId
          LEFT JOIN attributes a ON pva.attributeId = a.attributeId
          WHERE p.productStatus = 1 AND pv.productVariantStatus = 1";
//   AND a.attributeName = 'Dung lượng'

// Các tham số cho truy vấn chuẩn bị
$params = [];
$types = '';

if (!empty($searchQuery)) {
    $query .= " AND p.productName LIKE ?";
    $params[] = "%" . $searchQuery . "%";
    $types .= 's';
}

if (!empty($categoryName)) {
    $query .= " AND c.categoryName = ?";
    $params[] = $categoryName;
    $types .= 's';
}

// Thêm điều kiện tìm kiếm nâng cao vào truy vấn
if (!empty($category)) {
    $query .= " AND c.categoryName = ?";
    $params[] = $category;
    $types .= 's';
}

if (!empty($productLine)) {
    $query .= " AND pl.productLineId = ?";
    $params[] = $productLine;
    $types .= 'i';
}

if ($priceMin > 0) {
    $query .= " AND pv.price >= ?";
    $params[] = $priceMin;
    $types .= 'i';
}

if ($priceMax > 0) {
    $query .= " AND pv.price <= ?";
    $params[] = $priceMax;
    $types .= 'i';
}

// Sắp xếp theo giá
if ($sort === 'price_asc') {
    $query .= " ORDER BY pv.price ASC";
} elseif ($sort === 'price_desc') {
    $query .= " ORDER BY pv.price DESC";
} else {
    $query .= " ORDER BY p.productId DESC";
}

// Truy vấn số lượng sản phẩm tìm được
$countQuery = "SELECT COUNT(DISTINCT p.productId) AS totalProducts
               FROM products p
               LEFT JOIN categories c ON p.categoryId = c.categoryId
                LEFT JOIN productlines pl ON p.productLineId = pl.productLineId
               LEFT JOIN productvariants pv ON p.productId = pv.productId
               LEFT JOIN productvariantattributes pva ON pv.productVariantId = pva.productVariantId
               LEFT JOIN attributes a ON pva.attributeId = a.attributeId
               WHERE p.productStatus = 1 AND  pv.productVariantStatus = 1";
//    AND a.attributeName = 'Dung lượng'

if (!empty($searchQuery)) {
    $countQuery .= " AND p.productName LIKE ?";
}

if (!empty($categoryName)) {
    $countQuery .= " AND c.categoryName = ?";
}

$countQuery .= (!empty($category) ? " AND c.categoryName = ?" : "");
$countQuery .= (!empty($productLine) ? " AND pl.productLineId = ?" : "");
$countQuery .= ($priceMin > 0 ? " AND pv.price >= ?" : "");
$countQuery .= ($priceMax > 0 ? " AND pv.price <= ?" : "");

// Chuẩn bị và thực thi truy vấn đếm
$countStmt = mysqli_prepare($conn, $countQuery);
if (!empty($params)) {
    mysqli_stmt_bind_param($countStmt, $types, ...$params);
}
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$countRow = mysqli_fetch_assoc($countResult);
$totalProducts = $countRow['totalProducts'];

// Truy vấn sản phẩm
$stmt = mysqli_prepare($conn, $query);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Lấy danh sách sản phẩm và nhóm theo productId
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

<div class="filter-product-container">

    <span class="result-return">

        Có <?= $totalProducts ?> sản phẩm<?= (!empty($searchQuery) ? ' có tên "' . $searchQuery . '"' : '') ?>
        <?= (!empty($categoryName) ? ' trong thể loại "' . $categoryName . '"' : '') ?>

    </span>

    <!-- Dropdown sắp xếp theo giá -->
    <div class="sort-dropdown">
        <select id="sort-select">
            <option value="">Xếp theo: Nổi bật</option>
            <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Giá thấp đến cao</option>
            <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Giá cao đến thấp</option>
        </select>
    </div>
</div>

<!-- Hiển thị sản phẩm -->
<?php if (!empty($productData)): ?>
    <div class="product-grid">
        <?php foreach ($productData as $productId => $product): ?>
            <div class="product-item">
                <a href="product_detail.php?productId=<?= $productId ?>" class="product-link">
                    <img class="product-image" src="./images/<?= $product['productVariantImage'] ?>"
                        alt="<?= $product['productName'] ?>">
                    <h3 class="product-name"><?= $product['productName'] ?></h3>
                    <p class="product-price">Giá: <?= number_format($product['price'], 0, ',', '.') . '₫'; ?></p>
                </a>

                <!-- Nút chọn biến thể -->

            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <button class="pagination-btn prev-pagination" onclick="changePage(-1)">«</button>
        <div id="page-numbers"></div>
        <button class="pagination-btn next-pagination" onclick="changePage(1)">»</button>
    </div>
<?php else: ?>
    <div class="d-flex flex-column align-items-center justify-content-center w-100 mt-5">
        <i class="fa-regular fa-face-sad-tear display-1 text-secondary"></i>
        <p class="mt-3 text-muted">Không tìm thấy sản phẩm phù hợp.</p>
    </div>
<?php endif; ?>

<?php include("./includes/footer.php"); ?>




<script>
    // Sự kiện thay đổi lựa chọn sắp xếp
    document.getElementById('sort-select').addEventListener('change', function () {
        const sortValue = this.value;
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        window.location.search = urlParams.toString();
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

<style>
    .result-return {
        font-size: 23px;
        color: #333;
    }

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

    .filter-product-container {

        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px 30px 40px;
        flex-wrap: wrap;
        position: relative;
    }



    .sort-dropdown {
        text-align: right;
        float: right;
        position: relative;
        position: absolute;
        min-width: 150px;
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