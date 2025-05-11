<?php
session_start();
include("./functions/userfunctions.php");
if (isset($_SESSION['auth']))
    {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    $_SESSION['message']  = "Đăng xuất thành công!";
    $_SESSION['msg_type'] = "success";
    header("Location: login.php");
    exit();
    }
header('Location: login.php');
include("./includes/footer.php");

?>