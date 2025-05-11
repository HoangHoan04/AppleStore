<?php
include("../admin/includes/header.php");
?>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm slider</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><b>Tiêu đề slider</b></label>
                                    <input type="text" id="full-name" required name="sliderTitle"
                                        placeholder="Nhập tiêu đề slider" class="form-control">
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
                                    <label><b>Mô tả</b></label>
                                    <input type="text" required name="sliderDescription" placeholder="Nhập miêu tả"
                                        class="form-control">
                                </div>

                                <div class="col-md-12 image-upload-slider-preview">
                                    <label for="sliderImage">Tải ảnh lên</label>
                                    <input type="file" id="sliderImage" name="sliderImage" class="form-control"
                                        accept="image/*">
                                    <input type="hidden" name="old_image" value="<?= $data['sliderImage'] ?>">
                                    <img src="../images/<?= $data['sliderImage'] ?>" id="image-slider-preview"
                                        alt="Ảnh slider">
                                </div>



                                <div class="col-md-12">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="sliderStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary" name="add_slider_btn">Lưu slider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<link rel="stylesheet" href="./assets/css/style.css">
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<script type="text/javascript" src="./assets/js/index.js"></script>

<script>
document.getElementById('sliderImage').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-slider-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php include("../admin/includes/footer.php"); ?>