<?php
include("../admin/includes/header.php");

// Xử lý tìm kiếm và lọc thể loại
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$itemsPerPage = 6;
$offset = ($page - 1) * $itemsPerPage;

// Lấy danh sách thể loại
$categories = getAll("categories");

// Đếm tổng số sản phẩm phù hợp
$countQuery = "SELECT COUNT(*) as total FROM products WHERE 1";
if ($search !== '') {
    $countQuery .= " AND productName LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}
if ($filterCategory !== '') {
    $countQuery .= " AND categoryId = '" . mysqli_real_escape_string($conn, $filterCategory) . "'";
}
$totalResult = mysqli_query($conn, $countQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Truy vấn sản phẩm có phân trang
$query = "SELECT * FROM products WHERE 1";
if ($search !== '') {
    $query .= " AND productName LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}
if ($filterCategory !== '') {
    $query .= " AND categoryId = '" . mysqli_real_escape_string($conn, $filterCategory) . "'";
}
$query .= " LIMIT $itemsPerPage OFFSET $offset";
$products = mysqli_query($conn, $query);
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3>Sản phẩm</h3>
                        <a href="add-product.php" class="btn btn-success">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="ml-1">Thêm sản phẩm</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="mb-3 d-flex justify-content-between align-items-center gap-3">
                            <input type="text" name="search" value="<?= htmlspecialchars($search); ?>"
                                class="form-control w-25 p-2" placeholder="Tìm theo tên sản phẩm...">

                            <select name="category" class="form-select w-25 p-2 border rounded">
                                <option value="">Tất cả thể loại</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['categoryId']; ?>" <?= $filterCategory == $cat['categoryId'] ? 'selected' : ''; ?>>
                                        <?= $cat['categoryName']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="d-flex justify-content-between w-full p-3 ">
                                <button type="submit" class="mr-4 btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                                </button>
                                <a href="products.php" class="mb-0 ms-4 btn btn-secondary">Đặt lại</a>
                            </div>

                        </form>

                        <div class="product-cards">
                            <?php
                            if ($products && mysqli_num_rows($products) > 0):
                                foreach ($products as $item):
                                    $categoryName = "Không xác định";
                                    $productLineName = "Không xác định";

                                    $categoryId = $item['categoryId'];
                                    $catRes = mysqli_query($conn, "SELECT categoryName FROM categories WHERE categoryId = '$categoryId'");
                                    if ($catRes && mysqli_num_rows($catRes) > 0) {
                                        $cat = mysqli_fetch_assoc($catRes);
                                        $categoryName = $cat['categoryName'];
                                    }

                                    $productLineId = $item['productLineId'];
                                    $lineRes = mysqli_query($conn, "SELECT productLineName FROM productLines WHERE productLineId = '$productLineId'");
                                    if ($lineRes && mysqli_num_rows($lineRes) > 0) {
                                        $line = mysqli_fetch_assoc($lineRes);
                                        $productLineName = $line['productLineName'];
                                    }
                                    ?>
                                    <div
                                        class="product-card d-flex justify-content-between align-items-center p-3 border mb-2 rounded">
                                        <div class="product-info">
                                            <h5 class="mb-1"><?= $item['productName']; ?></h5>
                                            <p class="mb-1 text-muted">Danh mục: <?= $categoryName; ?></p>
                                            <p class="mb-1 text-muted">Dòng sản phẩm: <?= $productLineName; ?></p>
                                            <span
                                                class="badge <?= $item['productStatus'] == '1' ? 'bg-success' : 'bg-secondary'; ?>">
                                                <?= $item['productStatus'] == '1' ? "Đang hiển thị" : "Đã Ẩn"; ?>
                                            </span>
                                        </div>
                                        <div class="product-actions">
                                            <a href="product-information.php?productId=<?= $item['productId']; ?>"
                                                class="btn btn-success">
                                                <i class="fa-solid fa-circle-info"></i> Info
                                            </a>
                                            <a href="edit-product.php?productId=<?= $item['productId']; ?>"
                                                class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i> Sửa
                                            </a>
                                            <a class="btn btn-danger delete-btn" data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal"
                                                data-product-id="<?= $item['productId']; ?>">
                                                <i class="fa-solid fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach;
                            else:
                                echo "<p class='text-center'>Không có sản phẩm nào phù hợp</p>";
                            endif;
                            ?>
                        </div>

                        <!-- Phân trang -->
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php
                                $url = "products.php?search=" . urlencode($search) . "&category=" . urlencode($filterCategory);

                                if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= $url . "&page=" . ($page - 1); ?>">&laquo;</a>
                                    </li>
                                <?php endif;

                                for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?= $url . "&page=" . $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php endfor;

                                if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= $url . "&page=" . ($page + 1); ?>">&raquo;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal xác nhận -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa sản phẩm này không?
                    </div>
                    <div class="modal-footer d-flex gap-2">
                        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Hủy</button>
                        <form action="code.php" method="POST" id="delete-product-form" class="flex-fill">
                            <input type="hidden" name="productId" id="product-id-input">
                            <button type="submit" class="btn btn-danger w-100" name="delete_product_btn">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id');
            const inputField = document.getElementById('product-id-input');
            inputField.value = productId;
        });
    });
</script>

<?php include("../admin/includes/footer.php"); ?>
<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination button {
        border: none;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 5px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        color: #333;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .pagination button:hover:not(:disabled) {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination button.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>


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

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .product-card {
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin-bottom: 10px;
    }

    .product-image img {
        object-fit: cover;
        width: 470px;
        height: auto;
    }

    .product-info h5 {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .product-info p {
        font-size: 0.9rem;
    }

    .product-actions .btn {
        font-size: 0.9rem;
    }

    .product-actions i {
        margin-right: 5px;
    }
</style>