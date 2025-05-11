<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4>Chỉnh sửa biến thể sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <?php
                            if (isset($_GET['productVariantId'])) {
                                $productVariantId = $_GET['productVariantId'];
                                $query = "SELECT pv.*, p.productName 
                                          FROM productvariants pv 
                                          JOIN products p ON p.productId = pv.productId 
                                          WHERE pv.productVariantId = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $productVariantId);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($data = $result->fetch_assoc()):
                                    ?>
                                    <!-- Hidden Inputs -->
                                    <input type="hidden" name="productVariantId" value="<?= $data['productVariantId']; ?>">
                                    <input type="hidden" name="productId" value="<?= $data['productId']; ?>">
                                    <input type="hidden" name="productName" value="<?= $data['productName']; ?>">

                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" class="form-control" value="<?= $data['productName']; ?>" readonly>
                                    </div>
                                    <!-- Main Image -->
                                    <div class="form-group">
                                        <label>Ảnh chính</label>
                                        <input type="file" name="productVariantImage" class="form-control" accept="image/*">
                                        <?php if (!empty($data['productVariantImage'])): ?>
                                            <img src="../images/<?= $data['productVariantImage']; ?>" width="120" class="mt-2">
                                        <?php endif; ?>
                                    </div>

                                    <!-- Attributes -->
                                    <h5 class="mt-4">Thuộc tính</h5>
                                    <?php
                                    $attrQuery = "SELECT pva.*, a.attributeName 
                                                  FROM productvariantattributes pva 
                                                  JOIN attributes a ON a.attributeId = pva.attributeId 
                                                  WHERE pva.productVariantId = ? AND LOWER(a.attributeName) = 'ảnh phụ'"; // Lọc thuộc tính "Ảnh phụ"
                                    $stmt = $conn->prepare($attrQuery);
                                    $stmt->bind_param("i", $productVariantId);
                                    $stmt->execute();
                                    $attrs = $stmt->get_result();

                                    while ($row = $attrs->fetch_assoc()):
                                        ?>
                                        <div class="form-group mt-3">
                                            <label><?= $row['attributeName']; ?></label>
                                            <!-- Ảnh phụ -->
                                            <input type="file" name="attributeFile[]" class="form-control" accept="image/*">
                                            <input type="hidden" name="oldAttributeValue[]" value="<?= $row['attributeValue']; ?>">
                                            <?php if (!empty($row['attributeValue'])): ?>
                                                <img src="../images/<?= $row['attributeValue']; ?>" width="100" class="mt-2">
                                            <?php endif; ?>

                                            <!-- Hidden inputs -->
                                            <input type="hidden" name="attributeId[]" value="<?= $row['attributeId']; ?>">
                                            <input type="hidden" name="productVariantAttributeId[]"
                                                value="<?= $row['productVariantAttributeId']; ?>">
                                        </div>
                                    <?php endwhile; ?>

                                    <!-- Submit -->
                                    <button type="submit" name="update_product_subImage_variant_btn"
                                        class="btn btn-primary mt-4">
                                        Cập nhật
                                    </button>
                                    <?php
                                else:
                                    echo "<p>Không tìm thấy biến thể sản phẩm.</p>";
                                endif;
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include("../admin/includes/footer.php"); ?>