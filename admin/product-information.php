<?php include("../admin/includes/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['productId'])) {
                $productId = $_GET['productId'];

                $productQuery = "SELECT * FROM products WHERE productId = '$productId'";
                $productResult = mysqli_query($conn, $productQuery);

                if (mysqli_num_rows($productResult) > 0) {
                    $data = mysqli_fetch_array($productResult);
                    ?>
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4>Thông tin sản phẩm</h4>
                            <div class="product-info-actions d-flex gap-3">
                                <a href="add-product-variant.php?productId=<?= $data['productId'] ?>" class="btn btn-success">
                                    <i class="fa-solid fa-circle-info"></i> Thêm biến thể
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Tên sản phẩm:</strong> <?= htmlspecialchars($data['productName']) ?></p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Danh mục:</strong>
                                        <?php
                                        $categoryQuery = "SELECT categoryName FROM categories WHERE categoryId = '{$data['categoryId']}'";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);
                                        $category = mysqli_fetch_assoc($categoryResult);
                                        echo $category ? htmlspecialchars($category['categoryName']) : "Không có";
                                        ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Dòng sản phẩm:</strong>
                                        <?php
                                        $productLineQuery = "SELECT productLineName FROM productlines WHERE productLineId = '{$data['productLineId']}'";
                                        $productLineResult = mysqli_query($conn, $productLineQuery);
                                        $productLine = mysqli_fetch_assoc($productLineResult);
                                        echo $productLine ? htmlspecialchars($productLine['productLineName']) : "Không có";
                                        ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Trạng thái:</strong>
                                        <span class="badge bg-<?= $data['productStatus'] == '1' ? 'success' : 'secondary' ?>">
                                            <?= $data['productStatus'] == '1' ? "Hiển thị" : "Ẩn" ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-24">
                                    <h5>Biến thể sản phẩm</h5>
                                    <?php
                                    $variantQuery = "SELECT * FROM productvariants WHERE productId = ?";
                                    $stmt = mysqli_prepare($conn, $variantQuery);
                                    mysqli_stmt_bind_param($stmt, "i", $productId);
                                    mysqli_stmt_execute($stmt);
                                    $variantResult = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($variantResult) > 0) {
                                        echo '<div class="variant-list">';
                                        while ($variant = mysqli_fetch_assoc($variantResult)) {
                                            $variantId = $variant['productVariantId'];
                                            ?>
                                            <div class="variant-item">
                                                <div class="variant-info">
                                                    <p><strong>Giá:</strong> <?= number_format($variant['price'], 0) ?> VNĐ</p>

                                                    <img src="../images/<?= $variant['productVariantImage'] ?>" alt="Hình ảnh sản phẩm"
                                                        width="150">

                                                    <?php
                                                    // Truy vấn lấy thuộc tính của biến thể
                                                    $variantAttributeQuery = "SELECT a.attributeName, pva.attributeValue 
                                                        FROM productvariantattributes pva 
                                                        JOIN attributes a ON pva.attributeId = a.attributeId 
                                                        WHERE pva.productVariantId = ?";
                                                    $stmt = mysqli_prepare($conn, $variantAttributeQuery);
                                                    mysqli_stmt_bind_param($stmt, "i", $variantId);
                                                    mysqli_stmt_execute($stmt);
                                                    $variantAttributeResult = mysqli_stmt_get_result($stmt);

                                                    $textAttributes = []; // Lưu thuộc tính dạng text
                                                    $imageAttributes = []; // Lưu thuộc tính dạng ảnh
                                    
                                                    while ($variantAttr = mysqli_fetch_assoc($variantAttributeResult)) {
                                                        $attributeName = strtolower($variantAttr['attributeName']);
                                                        $attributeValue = htmlspecialchars($variantAttr['attributeValue']);

                                                        if ($attributeName == "màu") {
                                                            $textAttributes[] = "<span class='color-box' style='background-color: $attributeValue;'></span> $attributeValue";
                                                        } elseif (preg_match('/\.(jpg|jpeg|png|gif)$/i', $attributeValue)) {
                                                            $imageAttributes[] = "<img src='../images/{$attributeValue}' alt='{$attributeName}' width='50' height='50'>";
                                                        } else {
                                                            $textAttributes[] = "<span class='attr-text'>$attributeName: $attributeValue</span>";
                                                        }
                                                    }

                                                    if (!empty($imageAttributes)) {
                                                        echo "<div class='variant-sub-images'>";
                                                        foreach ($imageAttributes as $img) {
                                                            echo $img . " ";
                                                        }
                                                        echo "</div>";
                                                    }
                                                    ?>

                                                    <p><strong>Thuộc tính:</strong> <?= implode(" | ", $textAttributes) ?></p>
                                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                                        <p>Trạng thái: </p>
                                                        <p
                                                            class="status fs-6 <?= $variant['productVariantStatus'] == 1 ? 'text-success' : 'text-danger' ?>">
                                                            <?= $variant['productVariantStatus'] == 1 ? "Đang hiển thị" : "Đã ẩn"; ?>
                                                        </p>

                                                    </div>

                                                </div>

                                                <div class="variant-actions">
                                                    <a href="edit-product-subImage-variant.php?productId=<?= $productId ?>&productVariantId=<?= $variant['productVariantId']; ?>"
                                                        class="btn btn-primary">
                                                        <i class="fa-solid fa-pen-to-square"></i> Sửa ảnh
                                                    </a>
                                                    <a href="edit-product-information-variant.php?productId=<?= $productId ?>&productVariantId=<?= $variant['productVariantId']; ?>"
                                                        class="btn btn-primary">
                                                        <i class="fa-solid fa-pen-to-square"></i> Sửa thông tin
                                                    </a>
                                                    <a type="submit" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                        class="btn btn-danger"
                                                        data-productvariant-id="<?= $variant['productVariantId']; ?>"
                                                        data-product-id="<?= $variant['productId']; ?>">
                                                        <i class="fa-solid fa-trash"></i> Xóa
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        echo '</div>';

                                    } else {
                                        echo "<p>Không có biến thể nào.</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <a href="products.php" class="btn btn-primary">
                                        <i class="fa-solid fa-circle-left"></i> Quay lại
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<div class='alert alert-danger text-center'>Sản phẩm không tồn tại</div>";
                }
            } else {
                echo "<div class='alert alert-warning text-center'>Thiếu ID sản phẩm trên URL</div>";
            }
            ?>
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
                        Bạn có chắc chắn muốn xóa biến thể này không?
                    </div>
                    <div class="modal-footer d-flex gap-2">
                        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Hủy</button>
                        <form action="code.php" method="POST" class="delete-form flex-fill">
                            <input type="hidden" name="productVariantId" id="productvariant-id-input">
                            <input type="hidden" name="productId" id="product-id-input">
                            <button type="submit" name="delete_product_variant_btn"
                                class="btn btn-danger w-100">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Lấy nút được nhấn
                var productId = button.getAttribute('data-product-id'); // Lấy ID từ data-product-id
                var productVariantId = button.getAttribute('data-productvariant-id'); // Lấy ID biến thể từ data-productvariant-id
                var inputFieldProduct = document.getElementById('product-id-input');
                var inputFieldProductVariant = document.getElementById('productvariant-id-input');
                inputFieldProduct.value = productId; // Gán ID vào input ẩn của form xóa
                inputFieldProductVariant.value = productVariantId; // Gán ID vào input ẩn của form xóa
            });
        });
    </script>
</div>

<style>
    .variant-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .variant-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }

    .variant-info {
        flex-grow: 1;
    }

    .variant-info p {
        margin: 5px 0;
    }

    .color-box {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 1px solid #ccc;
        margin-right: 5px;
    }

    .attr-text {
        font-weight: 500;
        color: #333;
    }

    .variant-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>