<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm danh mục</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <!-- Uploads image -->

                            <div class="row">
                                <div class="col-md-12">
                                    <label for=""><b>Tên danh mục</b></label>
                                    <input type="text" id="categoryName" required name="categoryName"
                                        placeholder="Nhập tên danh mục" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for=""><b>Slug</b></label>
                                    <input type="text" id="categorySlug" required name="categorySlug"
                                        placeholder="Nhập slug" class="form-control">
                                </div>
                                <div class="col-md-24">
                                    <label for=""><b>Mô tả</b></label>
                                    <input type="text" required name="categoryDescription" placeholder="Nhập miêu tả"
                                        class="form-control">
                                </div>
                                <div class="col-md-12 image-add-category-preview">
                                    <label for="categoryImage">Tải ảnh lên</label>
                                    <input type="file" required name="categoryImage" id="categoryImage"
                                        class="form-control" accept="image/*">
                                    <img src="../images/<?= $data['categoryImage'] ?>" id="image-category-preview"
                                        alt="Ảnh category ">
                                    <input type="hidden" name="old_image" value="<?= $data['categoryImage'] ?>">
                                </div>
                                <div class="col-md-12 logo-add-category-preview">
                                    <label for="categoryLogo">Tải ảnh lên</label>
                                    <input type="file" required name="categoryLogo" id="categoryLogo"
                                        class="form-control" accept="image/*">
                                    <img src="../images/<?= $data['categoryLogo'] ?>" id="logo-category-preview"
                                        alt="logo category ">
                                    <input type="hidden" name="old_logo" value="<?= $data['categoryLogo'] ?>">
                                </div>
                                <div class="col-md-12">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="categoryStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="add_category_btn">Lưu danh mục
                                    </button>
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
<script>
document.getElementById("categoryName").addEventListener("keyup", function() {
    document.getElementById("categorySlug").value = convertToSlug(
        document.getElementById("categoryName").value
    );
});

tinymce.init({
    selector: "#myTextarea",
});
</script>
<?php include("../admin/includes/footer.php"); ?>