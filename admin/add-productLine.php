<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm dòng sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <!-- Uploads image -->
                            <div class="row">
                                <div class="col-md-12">
                                    <label for=""><b>Tên dòng sản phẩm</b></label>
                                    <input type="text" id="full-name" required name="productLineName"
                                        placeholder="Nhập tên dòng sản phẩm" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Chọn danh mục</b></label>
                                    <select name="categoryId" class="form-select mb-2">
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
                                <div class="col-md-24">
                                    <label for=""><b>Mô tả</b></label>
                                    <input type="text" required name="productLineDescription" placeholder="Nhập miêu tả"
                                        class="form-control">
                                </div>
                                <div class="col-md-24">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="productLineStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                                <div class="col-md-24">
                                    <br>
                                    <button type="submit" class="btn btn-primary"
                                        name="add_productLine_btn">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>
