<?php

$page = substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'], "/") + 1);

// Kiểm tra nếu đã đăng nhập
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : "Người dùng";
$userId = isset($_SESSION['UserId']) ? $_SESSION['UserId'] : null;
$userImage = "userImageDefault.png"; // Ảnh mặc định

if ($userId) {
    $query = "SELECT UserImage FROM users WHERE UserId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userImage = $row['UserImage'] ?: $userImage; // Nếu có ảnh trong CSDL thì lấy, không có thì dùng mặc định
    }
    $stmt->close();
}
?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5 d-flex align-items-center">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="index.php">
                        <p class="m-0"><b class="text-sm">Trang chủ</b></p>
                    </a>
                </li>
                <li class="breadcrumb-item text-sm opacity-5 text-dark active fw-bold fs-2" aria-current="page">
                    <?php
                    $titles = [
                        "index.php" => " ",
                        // Danh mục
                        "category.php" => "Danh mục",
                        // Danh mục/Thêm danh mục
                        "add-category.php" => "Thêm danh mục",
                        // Danh mục/Sửa danh mục
                        "edit-category.php" => "Sửa danh mục",
                        // Sản phẩm
                        "products.php" => "Sản phẩm",
                        // Sản phẩm/Thêm sản phẩm
                        "add-product.php" => "Thêm sản phẩm",
                        // Sản phẩm/Sửa sản phẩm
                        "edit-product.php" => "Sửa sản phẩm",
                        // Sản phẩm/Sửa thông tin sản phẩm
                        "edit-product-information-variant.php" => "Sửa thông tin sản phẩm",
                        "edit-product-subImage-variant.php" => "Sửa ảnh sản phẩm",
                        // Sản phẩm/Thông tin sản phẩm
                        "product-information.php" => "Thông tin sản phẩm",
                        // Sản phẩm/Thêm biến thể sản phẩm
                        "add-product-variant.php" => "Thêm biến thể sản phẩm",
                        // Slider
                        "slider.php" => "Slider",
                        // Slider/Thêm slider
                        "add-slider.php" => "Thêm slider",
                        // Slider/Sửa slider
                        "edit-slider.php" => "Sửa slider",
                        // Thuộc tính
                        "attribute.php" => "Thuộc tính",
                        // Thuộc tính/Thêm thuộc tính
                        "add-attribute.php" => "Thêm thuộc tính",
                        // Thuộc tính/Sửa thuộc tính
                        "edit-attribute.php" => "Sửa thuộc tính",
                        // Bài viết
                        "blog.php" => "Bài viết",
                        // Bài viết/Thêm bài viết
                        "add-blog.php" => "Thêm bài viết",
                        // Bài viết/Sửa bài viết
                        "edit-blog.php" => "Sửa bài viết",
                        // Dòng sản phẩm
                        "productLine.php" => "Dòng sản phẩm",
                        // Dòng sản phẩm/Thêm dòng sản phẩm
                        "add-productLine.php" => "Thêm dòng sản phẩm",
                        // Dòng sản phẩm/Sửa dòng sản phẩm
                        "edit-productLine.php" => "Sửa dòng sản phẩm",
                        // Quản lý người dùng
                        "user.php" => "Quản lý người dùng",
                        // Quản lý người dùng/Sửa người dùng
                        "edit-user.php" => "Chỉnh sửa người dùng",
                        // Quản lý đơn hàng
                        "order.php" => "Quản lý đơn hàng",
                        // Quản lý đơn hàng/Chi tiết đơn hàng
                        "order-detail.php" => "Chi tiết đơn hàng",
                        // Quản lý khuyến mãi
                        "discount.php" => "Chương trình khuyến mãi",
                        // Quản lý khuyến mãi/Thêm chương trình khuyến mãi
                        "add-discount.php" => "Thêm chương trình khuyến mãi",
                        "edit-discount.php" => "Sửa chương trình khuyến mãi",
                        // Thống kê
                        "statistic.php" => "Thống kê",

                    ];
                    echo isset($titles[$page]) ? $titles[$page] : "Trang không xác định";
                    ?>
                </li>
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex align-items-center" id="navbar">
            <div class="ms-auto d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <img src="../images/<?= htmlspecialchars($userImage) ?>" alt="UserAvatar" class="rounded-circle"
                        width="40" height="40">
                    <span class="ms-2 fw-bold"><?php echo htmlspecialchars($userName); ?></span>
                </div>

            </div>
        </div>
    </div>
</nav>