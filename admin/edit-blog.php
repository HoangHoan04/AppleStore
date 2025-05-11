<?php
include("../admin/includes/header.php");
?>
<script src="./assets/js/tinymce.min.js" referrerpolicy="origin"></script>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['blogId'])) {
                    $blogId = $_GET['blogId'];
                    $blog = getByIdBlog("blogs", $blogId);

                    if (mysqli_num_rows($blog) > 0) {
                        $data = mysqli_fetch_array($blog);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa bài viết: <?= $data['blogTitle'] ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <!-- Uploads image -->

                                    <div class="row">
                                        <input type="hidden" name="blogId" value="<?= $data['blogId'] ?>">
                                        <div class="col-md-12">
                                            <label for=""><b>Tiêu đề</b></label>
                                            <input type="text" id="blogTitle" required name="blogTitle"
                                                placeholder="Nhập tiêu đề bài viết" value="<?= $data['blogTitle'] ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-0"><b>Chọn danh mục</b></label>
                                            <select name="categoryId" class="form-select mb-2">
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
                                        <div class="col-md-12">
                                            <label for=""><b>Slug bài viết</b></label>
                                            <input type="text" id="blogSlug" required name="blogSlug" placeholder="Nhập slug bài viết"
                                                value="<?= $data['blogSlug'] ?>" class="form-control">
                                        </div>

                                        <div class="col-md-12 image-upload-blog-preview">

                                            <input type="file" id="blogImage" name="blogImage" class="form-control"
                                                accept="image/*">
                                            <input type="hidden" name="old_image" value="<?= $data['blogImage'] ?>">
                                            <img src="../images/<?= $data['blogImage'] ?>" id="image-blog-preview"
                                                alt="Ảnh blog">
                                            <label for="blogImage">Tải ảnh lên</label>
                                        </div>
                                        <div class="col-md-24">
                                            <label class="mb-0"><b>Mô tả</b></label>
                                            <textarea type="text" required="" style="height: 150px" name="blogDescription"
                                                placeholder="Nhập mô tả bài viết"
                                                class="form-control mb-2"><?= $data['blogDescription'] ?></textarea>
                                        </div>
                                        <div class="col-md-24">
                                            <label for=""><b>Nội dung</b></label>
                                            <textarea name="content" id="myTextarea"
                                                style="height: 500px; width: 100%"><?= $data['blogContent'] ?></textarea>
                                        </div>

                                        <div class="col-md-24">
                                            <label><b>Trạng thái</b></label>
                                            <label class="switch">
                                                <input type="checkbox" <?= $data['blogStatus'] ? "checked" : "" ?>
                                                    name="blogStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>
                                        <input type="hidden" name="update_blog_btn" value="true">
                                        <div class="col-md-12">
                                            <br>
                                            <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Blog not found";
                    }
                } else {
                    echo "Id missing from url";
                }
                ?>
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