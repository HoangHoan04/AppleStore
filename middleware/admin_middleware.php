<?php
if (session_status() == PHP_SESSION_NONE)
    {
    session_start();
    }
include("../functions/myfunctions.php");

if (isset($_SESSION['auth']))
    {
    // Kiểm tra quyền truy cập của người dùng
    if ($_SESSION['userRole'] != 4)
        {
        $_SESSION['message']  = "Bạn không có quyền truy cập trang này!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../index.php");
        exit();
        }

   
    }
else
    {
    // Nếu chưa đăng nhập
    $_SESSION['message']  = "Vui lòng đăng nhập để tiếp tục!";
    $_SESSION['msg_type'] = "error";
    header("Location: ../login.php");
    exit();
    }
?>