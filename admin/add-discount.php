<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm khuyến mãi</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mb-0"><b>Tên khuyến mãi</b></label>
                                    <input type="text" name="discountName" required placeholder="Nhập tên khuyến mãi" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label class="mb-0"><b>Slug (đường dẫn)</b></label>
                                    <input type="text" name="discountSlug" required placeholder="Ví dụ: giam-gia-tet" class="form-control">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="mb-0"><b>Mô tả</b></label>
                                    <textarea name="discountDescription" required rows="3" class="form-control" placeholder="Nhập mô tả chương trình khuyến mãi"></textarea>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label class="mb-0"><b>Phần trăm giảm giá (%)</b></label>
                                    <input type="number" name="discountPercentage" step="0.01" min="0" max="100" required placeholder="Ví dụ: 15.50" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0"><b>Ngày bắt đầu</b></label>
                                    <input type="datetime-local" name="discountStartDate" required class="form-control">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label class="mb-0"><b>Ngày kết thúc</b></label>
                                    <input type="datetime-local" name="discountEndDate" required class="form-control">
                                </div>

                                <div class="col-md-12 mt-5">
                                    <button type="submit" name="add_discount_btn" class="btn btn-primary w-100">Thêm</button>
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
<script type="text/javascript" src="./assets/js/index.js"></script>

<?php include("../admin/includes/footer.php"); ?>
