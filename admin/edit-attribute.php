<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['attributeId']))
                    {
                    $attributeId = $_GET['attributeId'];
                    $attribute   = getByIdAttribute("attributes", $attributeId);

                    if (mysqli_num_rows($attribute) > 0)
                        {
                        $data = mysqli_fetch_array($attribute);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa thuộc tính</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-24">
                                            <input type="hidden" name="attributeId" value="<?= $data['attributeId'] ?>">
                                            <label for=""><b>Tên danh mục</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['attributeName'] ?>"
                                                name="attributeName" placeholder="Nhập vào tên thuộc tính" class="form-control">
                                        </div>
                                        <div class="col-md-24">
                                            <label><b>Trạng thái</b></label>
                                            <label class="switch">
                                                <input type="checkbox" <?= $data['attributeStatus'] ? "checked" : "" ?>
                                                    name="attributeStatus">
                                                <span class="switch-span"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" name="update_attribute_btn">Cập
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
                        echo "attribute not found";
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
