<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['productLineId']))
                    {
                    $productLineId = $_GET['productLineId'];
                    $productLine   = getByIdProductLine("productlines", $productLineId);

                    if (mysqli_num_rows($productLine) > 0)
                        {
                        $data = mysqli_fetch_array($productLine);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa dòng sản phẩm</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="productLineId" value="<?= $data['productLineId'] ?>">
                                            <label for=""><b>Tên dòng sản phẩm</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['productLineName'] ?>"
                                                name="productLineName" placeholder="Nhập tên dòng sản phẩm"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-0"><b>Chọn danh mục</b></label>
                                            <select name="categoryId" class="form-select mb-2">
                                                <option value="">Chọn</option>
                                                <?php
                                                $categories = getAll("categories");
                                                if (mysqli_num_rows($categories) > 0)
                                                    {
                                                    while ($item = mysqli_fetch_assoc($categories))
                                                        {
                                                        $selected = ($data['categoryId'] == $item['categoryId']) ? "selected" : "";
                                                        ?>
                                                        <option value="<?= $item['categoryId']; ?>" <?= $selected; ?>>
                                                            <?= $item['categoryName']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                else
                                                    {
                                                    echo "<option value=''>No Category available</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-24">
                                            <label for=""><b>Mô tả</b></label>
                                            <input type="text" required value="<?= $data['productLineDescription'] ?>"
                                                name="productLineDescription" placeholder="Nhập mô tả dòng sản phẩm"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-24">
                                            <label><b>Trạng thái</b></label>
                                            <label class="switch">
                                                <input type="checkbox" <?= $data['productLineStatus'] ? "checked" : "" ?>
                                                    name="productLineStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-24">
                                            <button type="submit" class="btn btn-primary" name="update_productLine_btn">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        }
                    else
                        {
                        echo "productLine not found";
                        }
                    }
                else
                    {
                    echo "Id missing from URL";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>
<?php include("../admin/includes/footer.php"); ?>
