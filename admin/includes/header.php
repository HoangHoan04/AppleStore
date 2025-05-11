<?php
include("../middleware/admin_middleware.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Apple-Store-Admin
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Font Awesome Icons -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.min.css" rel="stylesheet" />
    <link rel="icon" href="../images/favicon/favicon.ico" type="image/x-icon">
    <link href="./assets/css/style.css" rel="stylesheet" />
    <!-- Bootstrap JS (Yêu cầu Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/index.js"></script>

</head>

<body class="g-sidenav-show  bg-gray-200">
    <?php
    if (isset($_SESSION['message']) && isset($_SESSION['msg_type'])):  // Kiểm tra xem thông báo và msg_type có tồn tại trong session không
        // Lấy thông báo và kiểu thông báo
        $message  = $_SESSION['message'];
        $msg_type = $_SESSION['msg_type'];

        // Định nghĩa các kiểu thông báo
        $toastConfig = [
            'success' => ['icon' => 'fa-solid fa-circle-check', 'title' => 'Success'],
            'info' => ['icon' => 'fa-solid fa-circle-info', 'title' => 'Info'],
            'warning' => ['icon' => 'fa-solid fa-circle-exclamation', 'title' => 'Warning'],
            'error' => ['icon' => 'fa-solid fa-circle-xmark', 'title' => 'Error'],
        ];

        // Thiết lập kiểu thông báo mặc định nếu không tìm thấy
        $type = $toastConfig[$msg_type] ?? ['icon' => 'fa-solid fa-circle-info', 'title' => 'Thông báo']; // Giá trị mặc định
    
        // Xóa thông báo sau khi hiển thị
        unset($_SESSION['message'], $_SESSION['msg_type']);
        ?>
    <div id="alert-message" class="alert <?= htmlspecialchars($msg_type) ?>">
        <span class="icon">
            <i class="<?= htmlspecialchars($type['icon']) ?>"></i>
        </span>
        <div class="content">
            <div class="header">
                <span class="title"><?= htmlspecialchars($type['title']) ?></span>
                <span class="close" onclick="closeAlert()">&times;</span>
            </div>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        </div>
    </div>
    <?php endif; ?>

    <?php include("sidebar.php"); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php include("navbar.php"); ?>

        <div class="container-fluid ">
            <div class="row  h-100">
                <div class="col-12">
                </div>
            </div>