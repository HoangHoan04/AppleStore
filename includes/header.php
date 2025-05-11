<?php
session_start();
include("./functions/userfunctions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apple.</title>
    <!-- FONT-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- ICON -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="icon" href="./images/favicon/favicon.ico" type="image/x-icon">
    <!-- JAVASCRIPT -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const alertMessage = document.getElementById("alert-message");
            if (alertMessage) {
                setTimeout(() => {
                    alertMessage.style.display = "none";
                }, 4000);
            }
            document.addEventListener("click", function (event) {
                if (event.target.classList.contains("close")) {
                    const parentAlert = event.target.closest("#alert-message");
                    if (parentAlert) {
                        parentAlert.style.display = "none";
                    }
                }
            });
            const advancedSearchBtn = document.getElementById('advanced-search-btn');
            const advancedSearchOptions = document.getElementById('advanced-search-options');
            const inputField = document.querySelector('.search-box input[type="text"]');
            const clearButton = document.getElementById('clear-btn');
            advancedSearchBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (advancedSearchOptions.style.display === 'none' || advancedSearchOptions.style.display === '') {
                    advancedSearchOptions.style.display = 'block';
                    setTimeout(() => advancedSearchOptions.classList.add('show'), 10);
                } else {
                    advancedSearchOptions.classList.remove('show');
                    setTimeout(() => advancedSearchOptions.style.display = 'none', 300);
                }
            });
            document.addEventListener('click', function (event) {
                const searchBox = document.querySelector('.search-box');
                if (!searchBox.contains(event.target)) {
                    advancedSearchOptions.classList.remove('show');
                    setTimeout(() => advancedSearchOptions.style.display = 'none', 300);
                }
            });
            inputField.addEventListener('focus', () => {
                clearButton.style.display = 'block';
            });
            inputField.addEventListener('blur', () => {
                if (!inputField.value) {
                    clearButton.style.display = 'none';
                }
            });
            inputField.addEventListener('input', () => {
                clearButton.style.display = inputField.value ? 'block' : 'none';
            });
        });

        function validateForm() {
            const inputs = document.querySelectorAll('input');
            let hasError = false;
            inputs.forEach(input => {
                const errorMessage = document.getElementById(input.id + '-error');
                if (input.value.trim() === '') {
                    hasError = true;
                    errorMessage.textContent = `Vui lòng nhập ${input.getAttribute('placeholder')}.`;
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });
            if (!hasError) {
            }
        }

        function clearInput() {
            const inputField = document.querySelector('.search-box input[type="text"]');
            inputField.value = '';
            inputField.focus();
        }
    </script>

</head>

<body>
    <!-- Toast -->
    <?php
    if (isset($_SESSION['message'])):
        $message = $_SESSION['message'];
        $msg_type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : '';
        ?>
        <?php
        $message = $_SESSION['message'];
        $msg_type = $_SESSION['msg_type'];
        $toastConfig = [
            'success' => ['icon' => 'fa-solid fa-circle-check', 'title' => 'Success'],
            'info' => ['icon' => 'fa-solid fa-circle-info', 'title' => 'Info'],
            'warning' => ['icon' => 'fa-solid fa-circle-exclamation', 'title' => 'Warning'],
            'error' => ['icon' => 'fa-solid fa-circle-xmark', 'title' => 'Error'],
        ];
        $type = $toastConfig[$msg_type] ?? ['icon' => '', 'title' => 'Thông báo'];
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
    <!-- Header -->
    <div class="header-wrapper" id="header-wrapper">
        <div class="container">
            <!-- top header -->
            <div class="top-header">
                <!-- logo -->
                <div class="logo-img">
                    <a href="./index.php"><img src="./images/logo.png" alt=""></a>
                </div>
                <!-- search box -->
                <div class="search-box">
                    <form action="product-search.php" method="GET" id="search-form">
                        <button type="button" id="advanced-search-btn" class="advanced-search-btn">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <input type="text" name="query" placeholder="Tìm kiếm sản phẩm">
                        <button type="submit" name="basic_search" value="1"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <button type="button" id="clear-btn" class="clear-btn" style="display:none;"
                            onclick="clearInput()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <div id="advanced-search-options" class="advanced-search-options" style="display: none;">
                            <div class="filter-container">
                                <div class="filter-group filter-category">
                                    <label for="category">Thể loại:</label>
                                    <select name="category" id="category">
                                        <option value="">Tất cả thể loại</option>
                                        <?php
                                        $categories = getCategoryAllActive("categories");
                                        if ($categories && mysqli_num_rows($categories) > 0) {
                                            while ($item = mysqli_fetch_assoc($categories)) {
                                                echo '<option value="' . htmlspecialchars($item['categoryName']) . '">' . htmlspecialchars($item['categoryName']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="filter-group filter-product-line">
                                    <label for="productLine">Dòng sản phẩm:</label>
                                    <select name="productLine" id="productLine">
                                        <option value="">Tất cả dòng sản phẩm</option>
                                        <?php
                                        $productLines = mysqli_query($conn, "SELECT productLineId, productLineName FROM productlines WHERE productLineStatus = 1");
                                        if ($productLines && mysqli_num_rows($productLines) > 0) {
                                            while ($line = mysqli_fetch_assoc($productLines)) {
                                                echo '<option value="' . htmlspecialchars($line['productLineId']) . '">' . htmlspecialchars($line['productLineName']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="filter-group filter-price">
                                    <label>Khoảng giá:</label>
                                    <div class="price-range">
                                        <input type="number" name="price_min" placeholder="Từ" min="0" step="100000">
                                        <span class="dash">-</span>
                                        <input type="number" name="price_max" placeholder="Đến" min="0" step="100000">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="advanced_search" value="1" class="apply-filter-btn">Áp
                                dụng</button>
                        </div>
                    </form>
                </div>

                <!-- user item -->
                <div class="list-user-item">
                    <ul class="user-menu">
                        <li><a href="./cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                        <?php
                        if (isset($_SESSION['auth'])) {
                            $userId = $_SESSION['auth_user']['userId'];
                            $query = "SELECT userName, userImage FROM users WHERE UserId = $userId LIMIT 1";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $user = mysqli_fetch_assoc($result);
                                $userName = $user['userName'];
                                $userImage = !empty($user['userImage']) ? $user['userImage'] : 'userImageDefault.png';
                            } else {
                                $userName = 'Người dùng';
                                $userImage = 'userImageDefault.png';
                            }
                            ?>
                            <li class="mega-dropdown">
                                <a href="#" style="display: flex; justify-content: center; align-items: center;">
                                    <img id="Image-header" src="./images/<?= htmlspecialchars($userImage) ?>"
                                        alt="Ảnh đại diện" class="img-thumbnail"
                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <span><?= htmlspecialchars($userName) ?></span>
                                </a>
                                <div class="mega-content">
                                    <div class="row-sign-in">
                                        <div class="dropdown-sign-in">
                                            <ul>
                                                <li><a href="user_profile.php">Trang cá nhân</a></li>
                                                <li><a href="./cart_status.php">Đơn hàng</a></li>
                                                <li><a href="user.php">Lịch sử mua hàng</a></li>
                                                <li><a href="logout.php">Đăng Xuất</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="mega-dropdown">
                                <a href="#"><i class="fa-solid fa-circle-user"></i></a>
                                <div class="mega-content">
                                    <div class="row-sign-in">
                                        <div class="dropdown-sign-in">
                                            <ul>
                                                <li><a href="login.php">Đăng nhập</a></li>
                                                <li><a href="register.php">Đăng ký</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }

                        ?>
                    </ul>
                </div>
            </div>
            <!-- bottom header -->
            <div class="bottom-header">
                <ul class="main-menu">
                    <!-- Hiển thị danh mục trực tiếp -->
                    <?php
                    $categories = getCategoryAllActive("categories");

                    if ($categories && mysqli_num_rows($categories) > 0) {
                        while ($item = mysqli_fetch_assoc($categories)) {
                            echo '<li><a href="./product.php?type=' . urlencode($item['categoryName']) . '">' . htmlspecialchars($item['categoryName']) . '</a></li>';
                        }
                    } else {
                        echo '<li><a href="#">Không có danh mục</a></li>';
                    }
                    ?>
                    <li><a href="./blog.php">Blog</a></li>
                    <li><a href="./care.php">AppleCare</a></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>