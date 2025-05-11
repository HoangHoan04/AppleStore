<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['categoryId'])) {
                    $categoryId = $_GET['categoryId'];
                    $category = getByIdCategory("categories", $categoryId);

                    if (mysqli_num_rows($category) > 0) {
                        $data = mysqli_fetch_array($category);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa danh mục</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="categoryId" value="<?= $data['categoryId'] ?>">
                                            <label for=""><b>Tên danh mục</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['categoryName'] ?>"
                                                name="categoryName" placeholder="Nhập tên thể loại" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label for=""><b>Slug danh mục</b></label>
                                            <input type="text" id="slug-name" required value="<?= $data['categorySlug'] ?>"
                                                name="categorySlug" placeholder="Nhập slug" class="form-control">
                                        </div>
                                        <div class="col-md-24">
                                            <label for=""><b>Mô tả</b></label>
                                            <input type="text" required value="<?= $data['categoryDescription'] ?>"
                                                name="categoryDescription" placeholder="Nhập mô tả thể loại"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-12 image-upload-category-preview">
                                            <label for="categoryImage">Tải ảnh lên</label>
                                            <input type="file" id="categoryImage" name="categoryImage" class="form-control"
                                                accept="image/*">
                                            <input type="hidden" name="old_image" value="<?= $data['categoryImage'] ?>">
                                            <img src="../images/<?= $data['categoryImage'] ?>" id="image-category-preview"
                                                alt="Ảnh category">
                                        </div>
                                        <div class="col-md-12 logo-upload-category-preview">
                                            <label for="categoryLogo">Tải ảnh lên</label>
                                            <input type="file" id="categoryLogo" name="categoryLogo" class="form-control"
                                                accept="images/*">
                                            <input type="hidden" name="old_logo" value="<?= $data['categoryLogo'] ?>">
                                            <img src="../images/<?= $data['categoryLogo'] ?>" id="logo-category-preview"
                                                alt="Ảnh logo">
                                        </div>

                                        <div class="col-md-12">
                                            <label><b>Trạng thái</b></label>
                                            <label class="switch">
                                                <input type="checkbox" <?= $data['categoryStatus'] ? "checked" : "" ?>
                                                    name="categoryStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" name="update_category_btn">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Category not found";
                    }
                } else {
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