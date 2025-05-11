<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm thuộc tính</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <!-- Uploads image -->

                            <div class="row">
                                <div class="col-md-24">
                                    <label for=""><b>Tên thuộc tính</b></label>
                                    <input type="text" id="attributeName" required name="attributeName"
                                        placeholder="Nhập tên thuộc tính" class="form-control">
                                </div>

                                <div class="col-md-24">
                                    <label><b>Trạng thái</b></label>
                                    <label class="switch">
                                        <input type="checkbox" name="attributeStatus">
                                        <span class="switch-span"></span>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="add_attribute_btn">Lưu thuộc
                                        tính
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<?php include("../admin/includes/footer.php"); ?>