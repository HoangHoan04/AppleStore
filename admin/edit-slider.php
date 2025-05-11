<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['sliderId'])) {
                    $sliderId = $_GET['sliderId'];
                    $slider = getByIdSlider("sliders", $sliderId);

                    if (mysqli_num_rows($slider) > 0) {
                        $data = mysqli_fetch_array($slider);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa slider</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="sliderId" value="<?= $data['sliderId'] ?>">
                                            <label><b>Tiêu đề</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['sliderTitle'] ?>"
                                                name="sliderTitle" placehor="Nhập tiêu đề slide" class="form-control">
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

                                        <div class="col-md-24">
                                            <label><b>Mô tả</b></label>
                                            <input type="text" required value="<?= $data['sliderDescription'] ?>"
                                                name="sliderDescription" placeholder="Nhập mô tả slide" class="form-control">
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
                                                <input type="checkbox" <?= $data['sliderStatus'] ? "checked" : "" ?>
                                                    name="sliderStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" name="update_slider_btn">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Slider not found";
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