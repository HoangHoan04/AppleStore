<?php
include("../admin/includes/header.php");

if (isset($_GET['discountId'])) {
    $discountId = $_GET['discountId'];

    $discount_query = "SELECT * FROM discounts WHERE discountId = '$discountId' LIMIT 1";
    $discount_result = mysqli_query($conn, $discount_query);

    if (mysqli_num_rows($discount_result) > 0) {
        $data = mysqli_fetch_array($discount_result);
        ?>
        <div class="container mt-5">
            <h3>Chỉnh sửa khuyến mãi</h3>
            <form action="code.php" method="POST">
                <input type="hidden" name="discountId" value="<?= $data['discountId']; ?>">

                <div class="mb-3">
                    <label class="form-label">Tên khuyến mãi</label>
                    <input type="text" name="discountName" value="<?= $data['discountName']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="discountSlug" value="<?= $data['discountSlug']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <input type="text" name="discountDescription" value="<?= $data['discountDescription']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phần trăm giảm giá (%)</label>
                    <input type="text" name="discountPercentage" value="<?= $data['discountPercentage']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" name="discountStartDate" value="<?= date('Y-m-d\TH:i', strtotime($data['discountStartDate'])); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" name="discountEndDate" value="<?= date('Y-m-d\TH:i', strtotime($data['discountEndDate'])); ?>" class="form-control" required>
                </div>

                <button type="submit" name="update_discount_btn" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
        <?php
    } else {
        echo "<h5>Không tìm thấy khuyến mãi</h5>";
    }
} else {
    echo "<h5>Thiếu ID khuyến mãi</h5>";
}

include("../admin/includes/footer.php");
?>
