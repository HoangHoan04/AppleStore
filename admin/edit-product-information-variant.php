<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
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

                                    <!-- Price -->
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input type="number" name="price" step="0.01" class="form-control"
                                            value="<?= $data['price']; ?>" required>
                                    </div>

                                    <!-- Attributes -->
                                    <h5 class="mt-4">Thuộc tính</h5>
                                    <?php
                                    $attrQuery = "SELECT pva.*, a.attributeName 
                                              FROM productvariantattributes pva 
                                              JOIN attributes a ON a.attributeId = pva.attributeId 
                                              WHERE pva.productVariantId = ?";
                                    $stmt = $conn->prepare($attrQuery);
                                    $stmt->bind_param("i", $productVariantId);
                                    $stmt->execute();
                                    $attrs = $stmt->get_result();

                                    while ($row = $attrs->fetch_assoc()):
                                        // Skip attributes named "Ảnh phụ"
                                        if (mb_strtolower($row['attributeName'], 'UTF-8') === 'ảnh phụ') {
                                            continue;
                                        }
                                        ?>
                                        <div class="form-group mt-3">
                                            <label><?= htmlspecialchars($row['attributeName']); ?></label>
                                            <input type="text" name="attributeValue[]" class="form-control"
                                                value="<?= htmlspecialchars($row['attributeValue']); ?>" required>
                                            <!-- Hidden inputs -->
                                            <input type="hidden" name="attributeId[]" value="<?= $row['attributeId']; ?>">
                                            <input type="hidden" name="productVariantAttributeId[]"
                                                value="<?= $row['productVariantAttributeId']; ?>">
                                        </div>
                                    <?php endwhile; ?>
                                    <div class="col-md-12">
                                        <label><b>Trạng thái</b></label>
                                        <label class="switch">
                                            <input type="checkbox" name="productVariantStatus" <?= $data['productVariantStatus'] == '1' ? "checked" : "" ?>>
                                            <span class="switch-span"></span>
                                        </label>
                                    </div>
                                    <!-- Submit -->
                                    <button type="submit" name="update_product_information_variant_btn"
                                        class="btn btn-primary mt-4">
                                        Cập nhật
                                    </button>
                                    <?php
                                else:
                                    echo "<p class='text-danger'>Không tìm thấy biến thể sản phẩm.</p>";
                                endif;
                            } else {
                                echo "<p class='text-danger'>Thiếu mã biến thể sản phẩm.</p>";
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