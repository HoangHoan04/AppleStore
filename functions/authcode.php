<?php
// Kết nối với cơ sở dữ liệu
include('../config/db_connection.php');
session_start();

// Xử lý khi người dùng nhấn nút đăng ký
if (isset($_POST['register_btn'])) {
    // Lấy thông tin từ form
    $userName = trim($_POST['userName']);
    $userEmail = trim($_POST['userEmail']);
    $userPhone = trim($_POST['userPhone']);
    $userPassword = $_POST['userPassword'];
    $userConfirmPassword = $_POST['userConfirmPassword'];

    // Kiểm tra mật khẩu có khớp không
    if ($userPassword !== $userConfirmPassword) {
        echo "<script>alert('Mật khẩu và xác nhận mật khẩu không khớp');</script>";
        exit();
    }

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Kiểm tra xem email đã tồn tại
    $checkEmailQuery = "SELECT * FROM users WHERE userEmail = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Email đã tồn tại!";
        $_SESSION['msg_type'] = "warning";
        header("Location: ../register.php");
        exit();
    }

    $userRole = 1;
    $createdAt = date('Y-m-d H:i:s');
    $insertQuery = "INSERT INTO users (userName, userEmail, userPhone, userPassword, userRole, create_at) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssss", $userName, $userEmail, $userPhone, $hashedPassword, $userRole, $createdAt);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Đăng ký tài khoản thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ../login.php");
        exit();
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại sau');</script>";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
if (isset($_POST['login_btn'])) {
    $userEmail = trim($_POST['userEmail']);
    $userPassword = $_POST['userPassword'];
    $rememberMe = isset($_POST['remember_me']);

    $checkUserQuery = "SELECT * FROM users WHERE userEmail = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['userStatus'] == 0) {
            $_SESSION['message'] = "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên!";
            $_SESSION['msg_type'] = "error";
            header("Location: ../login.php");
            exit();
        }

        if (password_verify($userPassword, $user['userPassword'])) {
            $_SESSION['auth'] = true;
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userEmail'] = $user['userEmail'];
            $_SESSION['userRole'] = $user['userRole'];
            $_SESSION['auth_user'] = [
                'userId' => $user['userId'],
                'userName' => $user['userName'],
                'userEmail' => $user['userEmail'],
                'userCity' => $user['userCity'],
                'userDistrict' => $user['userDistrict'],
                'userWard' => $user['userWard'],
                'userAddress' => $user['userAddress'],
                'userPhone' => $user['userPhone'],
            ];

            if ($rememberMe) {
                $existingAccounts = isset($_COOKIE['rememberedAccounts']) ? json_decode($_COOKIE['rememberedAccounts'], true) : [];
                $existingAccounts[$userEmail] = $userPassword;
                setcookie('rememberedAccounts', json_encode($existingAccounts), time() + (86400 * 30), '/');
            }

            if ($user['userRole'] == 4) {
                $_SESSION['message'] = "Đăng nhập quản trị thành công!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../admin/index.php");
                exit();
            } else {
                $_SESSION['message'] = "Đăng nhập thành công!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Mật khẩu không đúng!";
            $_SESSION['msg_type'] = "error";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Email không tồn tại!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../register.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['update_user_btn'])) {
    $userId = $_SESSION['auth_user']['userId'];
    $name = $_POST['userName'] ?: $_SESSION['auth_user']['userName'];
    $email = $_POST['userEmail'] ?: $_SESSION['auth_user']['userEmail'];
    $phone = $_POST['userPhone'] ?: $_SESSION['auth_user']['userPhone'];
    $password = $_POST['userPassword'];
    $cpassword = $_POST['userConfirmPassword'];
    $userCity = $_POST['userCity'] ?? '';
    $userDistrict = $_POST['userDistrict'] ?? '';
    $userWard = $_POST['userWard'] ?? '';
    $address = $_POST['userAddress'] ?? '';

    // Xử lý ảnh
    $userImage = $_SESSION['auth_user']['userImage'];
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] == 0) {
        $imageTmp = $_FILES['userImage']['tmp_name'];
        $imageExtension = strtolower(pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION));

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageExtension, $validExtensions)) {
            $timestamp = date('YmdHis');
            $imageNewName = "IMG_{$timestamp}.{$imageExtension}";
            $imageDestination = "../images/" . $imageNewName;

            if (!empty($userImage) && file_exists("../images/" . $userImage)) {
                unlink("../images/" . $userImage);
            }

            if (move_uploaded_file($imageTmp, $imageDestination)) {
                $userImage = $imageNewName;
            }
        } else {
            $_SESSION['message'] = "Chỉ chấp nhận ảnh JPG, JPEG, PNG hoặc GIF.";
            $_SESSION['msg_type'] = "error";
            header("Location: ../user_profile.php");
            exit();
        }
    }

    if (empty($password)) {
        // Nếu không thay đổi mật khẩu
        $updateQuery = "UPDATE users 
                SET userName=?, userEmail=?, userPhone=?, userCity=?, userDistrict=?, userWard=?, userAddress=?, userImage=? 
                WHERE userId=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssiiissi", $name, $email, $phone, $userCity, $userDistrict, $userWard, $address, $userImage, $userId);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Cập nhật thông tin thành công";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Có lỗi xảy ra, vui lòng thử lại";
            $_SESSION['msg_type'] = "error";
        }
    } else {
        if ($password === $cpassword) {
            // Mã hóa mật khẩu
            $p_hash = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users 
                SET userName=?, userEmail=?, userPhone=?, userCity=?, userDistrict=?, userWard=?, userAddress=?, userPassword=?, userImage=? 
                WHERE userId=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssiiisssi", $name, $email, $phone, $userCity, $userDistrict, $userWard, $address, $p_hash, $userImage, $userId);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Cập nhật thông tin thành công";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Có lỗi xảy ra, vui lòng thử lại";
                $_SESSION['msg_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Mật khẩu và xác nhận mật khẩu không khớp!";
            $_SESSION['msg_type'] = "error";
        }
    }

    // Cập nhật lại thông tin trong session
    $_SESSION['auth_user']['userName'] = $name;
    $_SESSION['auth_user']['userEmail'] = $email;
    $_SESSION['auth_user']['userPhone'] = $phone;
    $_SESSION['auth_user']['userImage'] = $userImage;
    $_SESSION['auth_user']['userCity'] = $userCity;
    $_SESSION['auth_user']['userDistrict'] = $userDistrict;
    $_SESSION['auth_user']['userWard'] = $userWard;
    $_SESSION['auth_user']['userAddress'] = $address;

    header("Location: ../user_profile.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password_btn'])) {
    $email = trim($_POST['userEmail']);
    $password = trim($_POST['userPassword']);
    $confirmPassword = trim($_POST['userConfirmPassword']);

    // Kiểm tra các trường có rỗng không
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin!";
        $_SESSION['msg_type'] = "warning";
        header("Location: ../forgot_password.php");
        exit();
    }

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Email không hợp lệ!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../forgot_password.php");
        exit();
    }

    // Kiểm tra mật khẩu khớp
    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "Mật khẩu xác nhận không khớp!";
        $_SESSION['msg_type'] = "error";
        header("Location: ../forgot_password.php");
        exit();
    }

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Kiểm tra email trong cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM users WHERE UserEmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email tồn tại, cập nhật mật khẩu
            $updateStmt = $conn->prepare("UPDATE users SET UserPassword = ? WHERE UserEmail = ?");
            $updateStmt->bind_param("ss", $hashedPassword, $email);

            if ($updateStmt->execute()) {
                $_SESSION['message'] = "Mật khẩu đã được cập nhật thành công!";
                $_SESSION['msg_type'] = "success";
                header("Location: ../login.php");
                exit();
            } else {
                $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật mật khẩu!";
                $_SESSION['msg_type'] = "warning";
                header("Location: ../forgot_password.php");
                exit();
            }
        } else {
            // Email không tồn tại
            $_SESSION['message'] = "Email không tồn tại trong hệ thống!";
            $_SESSION['msg_type'] = "error";
            header("Location: ../forgot_password.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Đã xảy ra lỗi: " . $e->getMessage();
        $_SESSION['msg_type'] = "warning";
        header("Location: ../forgot_password.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Yêu cầu không hợp lệ!";
    $_SESSION['msg_type'] = "warning";
    header("Location: ../forgot_password.php");
    exit();
}

function require_login()
{
    $_SESSION['message'] = "Vui lòng đăng nhập để tiếp tục!";
    $_SESSION['msg_type'] = "error";
    header("Location: ./login.php"); // đổi thành ../login.php nếu file gọi ở trong thư mục con
    exit();
}


mysqli_close($conn);

?>