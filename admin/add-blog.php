<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm bài viết</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for=""><b>Tiêu đề</b></label>
                                    <input type="text" id="blogTitle" required name="blogTitle"
                                        placeholder="Nhập tên bài viết" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for=""><b>Slug</b></label>
                                    <input type="text" id="blogSlug" required name="blogSlug"
                                        placeholder="Nhập vào slug" class="form-control">
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
                                <div class="col-md-24 image-upload-blog-preview">

                                    <input type="file" required name="blogImage" id="blogImage" class="form-control"
                                        accept="image/*">
                                    <img src="../images/<?= $data['blogImage'] ?>" id="image-blog-preview"
                                        alt="Ảnh blog ">
                                    <input type="hidden" name="old_image" value="<?= $data['blogImage'] ?>">
                                    <label for="blogImage">Tải ảnh lên</label>
                                </div>
                                <div class="col-md-24">
                                    <label class="mb-0"><b>Mô tả</b></label>
                                    <textarea type="text" style="height: 150px" required="" name="blogDescription"
                                        placeholder="Nhập một đoạn" class="form-control mb-2"></textarea>
                                </div>
                                <div class="col-md-24">
                                    <label for="mb-0"><b>Nội dung</b></label>
                                    <textarea type="text" required="" class="form-control mb-2" name="blogContent"
                                        id="myTextarea" style="height: 500px"></textarea>
                                </div>
                                <div class="col-md-24">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="blogStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                                <input type="hidden" name="add_blog_btn" value="true">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Tạo bài viết</button>
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
<script>
    document
        .getElementById("blogImage")
        .addEventListener("change", function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById("image-blog-preview");

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

    document.getElementById("blogTitle").addEventListener("keyup", function () {
        document.getElementById("blogSlug").value = convertToSlug(
            document.getElementById("blogTitle").value
        );
    });

    tinymce.init({
        selector: "#myTextarea",
    });
</script>
<?php include("../admin/includes/footer.php"); ?>
