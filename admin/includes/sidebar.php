<?php

$page = substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gray-600"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <span class="ms-1 font-weight-bold text-white">TRUNG TÂM ĐIỀU KHIỂN</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse overflow-y-hidden w-auto" id="sidenav-collapse-main" style="height: 75vh">
        <ul class="navbar-nav">
            <!-- Trang chủ -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "index.php" ? 'active bg-black ' : '' ?>"
                    href="../admin/index.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Trang chủ</span>
                </a>
            </li>
            <!-- Quản lý  -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "category.php" ? 'active bg-black ' : '' ?>"
                    href="category.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Danh mục</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "productLine.php" ? 'active bg-black ' : '' ?>"
                    href="productLine.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Dòng sản phẩm</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "attribute.php" ? 'active bg-black ' : '' ?>"
                    href="attribute.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">edit</i>
                    </div>
                    <span class="nav-link-text ms-1">Thuộc tính</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "slider.php" ? 'active bg-black ' : '' ?>"
                    href="slider.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Slider</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "blog.php" ? 'active bg-black ' : '' ?>"
                    href="blog.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Bài viết</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "products.php" ? 'active bg-black ' : '' ?>"
                    href="products.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Sản phẩm</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "discount.php" ? 'active bg-black ' : '' ?>"
                    href="discount.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">discount</i>
                    </div>
                    <span class="nav-link-text ms-1">Khuyến mãi</span>
                </a>
            </li>
            <!-- Hoạt động -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "order.php" ? 'active bg-black ' : '' ?>"
                    href="order.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <span class="nav-link-text ms-1">Đơn hàng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "statistic.php" ? 'active bg-black ' : '' ?>"
                    href="statistic.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <span class="nav-link-text ms-1">Thống kê</span>
                </a>
            </li>
            <!-- Hệ thống -->
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "user.php" ? 'active bg-black ' : '' ?>"
                    href="user.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Người dùng</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-danger mt-4 w-100" href="../logout.php" type="button">Đăng xuất</a>
        </div>
    </div>
</aside>