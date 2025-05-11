<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <!-- Uploads images -->
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Tên sản phẩm</b></label>
                                    <input type="text" id="full-name" required name="productName"
                                        placeholder="Nhập tên sản phẩm" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Chọn danh mục</b></label>
                                    <select name="categoryId" class="attribute-select form-control">
                                        <option selected>Chọn</option>
                                        <?php
                                        $categories = getAll("categories");
                                        if (mysqli_num_rows($categories) > 0)
                                            {
                                            foreach ($categories as $item)
                                                {
                                                ?>
                                        <option value="<?= $item['categoryId']; ?>"> <?= $item['categoryName'] ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                        else
                                            {
                                            echo "No Category available";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Chọn dòng sản phẩm</b></label>
                                    <select name="productLineId" class="attribute-select form-control">
                                        <option selected>Chọn</option>
                                        <?php
                                        $productLines = getAll("productLines");
                                        if (mysqli_num_rows($productLines) > 0)
                                            {
                                            foreach ($productLines as $item)
                                                {
                                                ?>
                                        <option value="<?= $item['productLineId']; ?>">
                                            <?= $item['productLineName'] ?>
                                        </option>
                                        <?php
                                                }
                                            }
                                        else
                                            {
                                            echo "No productLine available";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Mô tả sản phẩm</b></label>
                                    <textarea id="description" name="description" rows="4"
                                        placeholder="Nhập mô tả sản phẩm" class="form-control"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="productStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-100" name="add_product_btn">Thêm</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>