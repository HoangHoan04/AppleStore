<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['productId'])) {
                    $productId = $_GET['productId'];
                    $product = getByIdProduct("products", $productId);

                    if (mysqli_num_rows($product) > 0) {
                        $data = mysqli_fetch_array($product);
                ?>
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4>Chỉnh sửa sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="productId" value="<?= $data['productId'] ?>">
                                    <label for="" class="mb-0"><b>Tên sản phẩm</b></label>
                                    <input type="text" id="full-name" required value="<?= $data['productName'] ?>"
                                        name="productName" placeholder="Nhập tên sản phẩm" class="form-control" readOnly>
                                </div>
                                <!-- Hiển thị danh mục -->
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Chọn danh mục</b></label>
                                    <select name="categoryId" class="attribute-select form-control">
                                        <option value="">Chọn</option>
                                        <?php
                                        $categories = getAll("categories");
                                        if (mysqli_num_rows($categories) > 0) {
                                            while ($item = mysqli_fetch_assoc($categories)) {
                                                $selected = ($data['categoryId'] == $item['categoryId']) ? "selected" : "";
                                        ?>
                                        <option value="<?= $item['categoryId']; ?>" <?= $selected; ?>>
                                            <?= $item['categoryName']; ?>
                                        </option>
                                        <?php
                                            }
                                        } else {
                                            echo "<option value=''>No Category available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- Hiển thị dòng sản phẩm -->
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Chọn dòng sản phẩm</b></label>
                                    <select name="productLineId" class="attribute-select form-control">
                                        <option value="">Chọn</option>
                                        <?php
                                        $productLines = getAll("productLines");
                                        if (mysqli_num_rows($productLines) > 0) {
                                            while ($item = mysqli_fetch_assoc($productLines)) {
                                                $selected = ($data['productLineId'] == $item['productLineId']) ? "selected" : "";
                                        ?>
                                        <option value="<?= $item['productLineId']; ?>" <?= $selected; ?>>
                                            <?= $item['productLineName']; ?>
                                        </option>
                                        <?php
                                            }
                                        } else {
                                            echo "<option value=''>No ProductLine available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Mô tả sản phẩm</b></label>
                                    <textarea id="description" name="description" rows="4"
                                        placeholder="Nhập mô tả sản phẩm" class="form-control"><?= $data['description'] ?></textarea>
                                </div>
                                <!-- Hiển thị trạng thái sản phẩm -->
                                <div class="col-md-12">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="productStatus"
                                            <?= $data['productStatus'] == '1' ? "checked" : "" ?>>
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex flex-column align-items-center gap-2">
                                        <button type="submit" class="btn btn-success" name="update_product_btn">
                                            <i class="fa-regular fa-circle-check"></i>
                                            Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                    } else {
                        echo "<p class='text-center'>Sản phẩm không tồn tại</p>";
                    }
                } else {
                    echo "<p class='text-center'>Thiếu ID sản phẩm trên URL</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>