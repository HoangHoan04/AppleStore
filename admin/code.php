<?php
session_start();
include("../middleware/admin_middleware.php");
include("../config/db_connection.php");

// ========================================================================= USER ACTION ==================================================================================

if (isset($_POST['lock_user_btn'])) {
    $userId = $_POST['userId'];

    // Lấy thông tin user
    $checkUser = "SELECT * FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $checkUser);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $newStatus = ($user['userStatus'] == 1) ? 0 : 1;
        $updateQuery = "UPDATE users SET userStatus = ? WHERE userId = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ii", $newStatus, $userId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = ($newStatus == 0) ? "Người dùng đã bị khóa." : "Người dùng đã được mở khóa.";
            $_SESSION['msg_type'] = "success";
            header("Location: user.php");
            exit();
        } else {
            $_SESSION['message'] = "Lỗi khi cập nhật trạng thái người dùng.";
            $_SESSION['msg_type'] = "error";
            header("Location: user.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Người dùng không tồn tại.";
        $_SESSION['msg_type'] = "error";
        header("Location: user.php");
        exit();
    }
}


if (isset($_POST['resetpassword_user_btn'])) {
    $userId = $_POST['userId'];

    // Lấy thông tin user
    $checkUser = "SELECT * FROM users WHERE userId = ?";
    $stmt = mysqli_prepare($conn, $checkUser);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $newPassword = password_hash("123456", PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET userPassword = ? WHERE userId = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "si", $newPassword, $userId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Đã đặt lại mật khẩu người dùng!";
            $_SESSION['msg_type'] = "success";
            header("Location: user.php");
            exit();
        } else {
            $_SESSION['message'] = "Lỗi khi đặt lại mật khẩu người dùng.";
            $_SESSION['msg_type'] = "error";
            header("Location: user.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Người dùng không tồn tại.";
        $_SESSION['msg_type'] = "error";
        header("Location: user.php");
        exit();
    }
}


// ============================================================== EDIT USER =======================================================
if (isset($_POST['update_info_user_btn'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPhone = mysqli_real_escape_string($conn, $_POST['userPhone']);
    $userAddress = mysqli_real_escape_string($conn, $_POST['userAddress']);
    $userCity = mysqli_real_escape_string($conn, $_POST['userCity']);
    $userDistrict = mysqli_real_escape_string($conn, $_POST['userDistrict']);
    $userWard = mysqli_real_escape_string($conn, $_POST['userWard']);
    $userStatus = isset($_POST['userStatus']) ? 1 : 0;
    $userImage = $_SESSION['auth_user']['userImage']; // Ảnh cũ mặc định

    // Xử lý ảnh nếu người dùng upload ảnh mới
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] == 0) {
        $imageTmp = $_FILES['userImage']['tmp_name'];
        $imageExtension = strtolower(pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION));

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageExtension, $validExtensions)) {
            $timestamp = date('YmdHis');
            $imageNewName = "IMG_{$timestamp}.{$imageExtension}";
            $imageDestination = "../images/" . $imageNewName;

            // Xóa ảnh cũ nếu có
            if (!empty($userImage) && file_exists("../images/" . $userImage)) {
                unlink("../images/" . $userImage);
            }

            // Di chuyển ảnh mới
            if (move_uploaded_file($imageTmp, $imageDestination)) {
                $userImage = $imageNewName;
            } else {
                $_SESSION['message'] = "Tải ảnh thất bại.";
                $_SESSION['msg_type'] = "error";
                header("Location: ../user_profile.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Chỉ chấp nhận ảnh JPG, JPEG, PNG hoặc GIF.";
            $_SESSION['msg_type'] = "error";
            header("Location: ../user_profile.php");
            exit();
        }
    }

    // Câu truy vấn cập nhật thông tin
    $query = "UPDATE users SET 
                userName = '$userName',
                userEmail = '$userEmail',
                userPhone = '$userPhone',
                userAddress = '$userAddress',
                userCity = '$userCity',
                userDistrict = '$userDistrict',
                userWard = '$userWard',
                userImage = '$userImage',
                userStatus = '$userStatus'
              WHERE userId = '$userId'";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Cập nhật thông tin người dùng thành công!";
        header("Location: user.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Cập nhật thất bại. Vui lòng thử lại.";
        header("Location: edit-user.php?userId=$userId");
        exit(0);
    }
}

// ============================================================== ACTION CATEGORY =======================================================

function generateImageName($prefix = "AMD")
{
    return $prefix . "_" . date("dmYHis");
}

function generateLogoCategoryName($prefix = "LOGO")
{
    return $prefix . "_" . date("dmYHis");
}
// ============================================================== ADD CATEGORY =======================================================
if (isset($_POST['add_category_btn'])) {
    $name = $_POST['categoryName'];
    $slug = $_POST['categorySlug'] . "-" . rand(10, 99);
    $description = $_POST['categoryDescription'];
    $status = isset($_POST['categoryStatus']) ? '1' : '0';
    $image = $_FILES['categoryImage']['name'];
    $logo = $_FILES['categoryLogo']['name'];
    $path = "../images";

    if ($image != "") {
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $filename = generateImageName() . '.' . $image_ext;
    } else {
        $filename = "";
    }
    if ($logo != "") {
        $logo_ext = pathinfo($logo, PATHINFO_EXTENSION);
        $filelogoname = generateLogoCategoryName() . '.' . $logo_ext;
    } else {
        $filelogoname = "";
    }

    $cate_query = "INSERT INTO categories (categoryName, categorySlug, categoryDescription, categoryImage, categoryStatus, create_at, categoryLogo) 
    VALUES ('$name', '$slug', '$description', '$filename', '$status', NOW(),'$filelogoname' )";

    $cate_query_run = mysqli_query($conn, $cate_query);

    if ($cate_query_run) {
        if ($image != "") {
            move_uploaded_file($_FILES['categoryImage']['tmp_name'], $path . '/' . $filename);
        }
        if ($logo != "") {
            move_uploaded_file($_FILES['categoryLogo']['tmp_name'], $path . '/' . $filelogoname);
        }
        $_SESSION['message'] = "Thêm danh mục thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./category.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./add-category.php");
        exit();
    }
}
// ============================================================== EDIT CATEGORY =======================================================
else if (isset($_POST['update_category_btn'])) {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];
    $categorySlug = $_POST['categorySlug'];
    $categoryDescription = $_POST['categoryDescription'];
    $categoryStatus = isset($_POST['categoryStatus']) ? '1' : '0';
    $new_image = $_FILES['categoryImage']['name'];
    $old_image = $_POST['old_image'];
    $new_logo = $_FILES['categoryLogo']['name'];
    $old_logo = $_POST['old_logo'];
    $path = "../images";

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = generateImageName() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }
    if ($new_logo != "") {
        $logo_ext = pathinfo($new_logo, PATHINFO_EXTENSION);
        $update_filelogoname = generateLogoCategoryName() . '.' . $logo_ext;
    } else {
        $update_filelogoname = $old_logo;
    }

    $update_query = "UPDATE categories 
    SET categoryName='$categoryName', 
        categorySlug='$categorySlug', 
        categoryDescription='$categoryDescription', 
        categoryImage='$update_filename', 
        categoryStatus='$categoryStatus', 
        create_at=NOW() ,
        categoryLogo = '$update_filelogoname'
    WHERE categoryId='$categoryId'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($new_image != "") {
            move_uploaded_file($_FILES['categoryImage']['tmp_name'], $path . '/' . $update_filename);

            // Xóa ảnh cũ nếu tồn tại
            if (file_exists($path . "/" . $old_image) && $old_image != "") {
                unlink($path . "/" . $old_image);
            }
        }
        if ($new_logo != "") {
            move_uploaded_file($_FILES['categoryLogo']['tmp_name'], $path . '/' . $update_filelogoname);

            // Xóa logo cũ nếu tồn tại
            if (file_exists($path . "/" . $old_logo) && $old_logo != "") {
                unlink($path . "/" . $old_logo);
            }
        }
        $_SESSION['message'] = "Cập nhật danh mục thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./category.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./edit-category.php?categoryId=$categoryId");
        exit();
    }
}
// ============================================================== DELETE CATEGORY =======================================================
else if (isset($_POST['delete_category_btn'])) {
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);


    // Tiến hành xóa danh mục
    $category_query = "SELECT * FROM categories WHERE categoryId='$categoryId'";
    $category_query_run = mysqli_query($conn, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['categoryImage'];
    $logo = $category_data['categoryLogo'];

    $delete_query = "DELETE FROM categories WHERE categoryId='$categoryId'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        // Xóa ảnh nếu tồn tại
        if (file_exists("../images/" . $image)) {
            unlink("../images/" . $image);
        }
        if (file_exists("../images/" . $logo)) {
            unlink("../images/" . $logo);
        }
        $_SESSION['message'] = "Xóa danh mục thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./category.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi khi xóa danh mục";
        $_SESSION['msg_type'] = "error";
        header("Location: ./category.php");
        exit();
    }
}

//=============================================================== ACTION SLIDER =============================================
// ============================================================== ADD SLIDER =======================================================
if (isset($_POST['add_slider_btn'])) {
    $sliderTitle = mysqli_real_escape_string($conn, $_POST['sliderTitle']);
    $sliderDescription = mysqli_real_escape_string($conn, $_POST['sliderDescription']);
    $sliderStatus = isset($_POST['sliderStatus']) ? 1 : 0;
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);


    $sliderImage = $_FILES['sliderImage']['name'];

    if (!empty($sliderImage)) {
        $timestamp = date("dmY");
        $imageName = "SLD_" . $timestamp . "_" . basename($sliderImage);
        $uploadPath = "../images/" . $imageName;

        // Upload ảnh
        if (move_uploaded_file($_FILES['sliderImage']['tmp_name'], $uploadPath)) {
            $query = "INSERT INTO sliders (sliderTitle, sliderImage, sliderDescription, sliderStatus, createdAt, categoryId)
VALUES ('$sliderTitle', '$imageName', '$sliderDescription', '$sliderStatus', NOW(), '$categoryId')";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $_SESSION['message'] = "Thêm slide thành công";
                $_SESSION['msg_type'] = "success";
                header("Location: ./slider.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Lỗi thêm slider";
                $_SESSION['msg_type'] = "error";
                header("Location: ./add_slider.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Lỗi tải ảnh lên";
            $_SESSION['msg_type'] = "error";
            header("Location: ./add_slider.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Vui lòng tải ảnh lên";
        $_SESSION['msg_type'] = "warning";
        header("Location: add_slider.php");
        exit(0);
    }
}
// ============================================================== EDIT SLIDER =======================================================
if (isset($_POST['update_slider_btn'])) {
    $sliderId = $_POST['sliderId'];
    $sliderTitle = mysqli_real_escape_string($conn, $_POST['sliderTitle']);
    $sliderDescription = mysqli_real_escape_string($conn, $_POST['sliderDescription']);
    $sliderStatus = isset($_POST['sliderStatus']) ? 1 : 0;
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    $oldImage = $_POST['old_image'];
    $newImage = $_FILES['sliderImage']['name'];

    $imageName = $oldImage; // Mặc định giữ ảnh cũ nếu không tải ảnh mới

    if (!empty($newImage)) {
        $timestamp = date("dmY");
        $imageName = "SLD_" . $timestamp . "_" . basename($newImage);
        $uploadPath = "../images/" . $imageName;

        // Upload ảnh mới
        if (!move_uploaded_file($_FILES['sliderImage']['tmp_name'], $uploadPath)) {
            $_SESSION['message'] = "Lỗi tải ảnh lên";
            $_SESSION['msg_type'] = "error";
            header("Location: edit_slider.php?sliderId=$sliderId");
            exit(0);
        }

        // Xóa ảnh cũ nếu ảnh mới được tải lên
        if (file_exists("../images/" . $oldImage)) {
            unlink("../images/" . $oldImage);
        }
    }

    // Cập nhật thông tin vào cơ sở dữ liệu
    $query = "UPDATE sliders SET sliderTitle='$sliderTitle', sliderImage='$imageName',
sliderDescription='$sliderDescription', sliderStatus='$sliderStatus', categoryId='$categoryId'
WHERE sliderId='$sliderId'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Cập nhật slide thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./slider.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Cập nhật lỗi!";
        $_SESSION['msg_type'] = "warning";
        header("Location: ./edit_slider.php?sliderId=$sliderId");
        exit(0);
    }
}
// ============================================================== DELETE SLIDER =======================================================
if (isset($_POST['delete_slider_btn'])) {
    // Lấy sliderId và tránh SQL injection
    $sliderId = mysqli_real_escape_string($conn, $_POST['sliderId']);

    // Tiến hành lấy thông tin slider
    $slider_query = "SELECT * FROM sliders WHERE sliderId='$sliderId'";
    $slider_query_run = mysqli_query($conn, $slider_query);

    if (mysqli_num_rows($slider_query_run) > 0) {
        $slider_data = mysqli_fetch_array($slider_query_run);
        $image = $slider_data['sliderImage'];

        // Thực hiện xóa slider
        $delete_query = "DELETE FROM sliders WHERE sliderId='$sliderId'"; // Sửa từ 'silderId' thành 'sliderId'
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            // Xóa ảnh nếu tồn tại
            if (file_exists("../images/" . $image)) {
                unlink("../images/" . $image);
            }
            // Thiết lập thông báo thành công
            $_SESSION['message'] = "Xóa slider thành công";
            $_SESSION['msg_type'] = "success";
        } else {
            // Nếu có lỗi trong việc xóa slider
            $_SESSION['message'] = "Đã xảy ra lỗi khi xóa slider";
            $_SESSION['msg_type'] = "error";
        }
    } else {
        // Nếu không tìm thấy slider
        $_SESSION['message'] = "Slider không tồn tại";
        $_SESSION['msg_type'] = "error";
    }

    // Điều hướng lại về trang slider
    header("Location: ./slider.php");
    exit();
}
// ============================================================= ACTION ATTRIBUTE ===========================================================
// ============================================================== ADD ATTRIBUTE =======================================================
if (isset($_POST['add_attribute_btn'])) {
    $attributeName = $_POST['attributeName'];
    $attributeStatus = isset($_POST['attributeStatus']) ? '1' : '0';

    $attribute_query = "INSERT INTO attributes (attributeName, attributeStatus, create_at)
VALUES ('$attributeName', '$attributeStatus', NOW())";

    $attribute_query_run = mysqli_query($conn, $attribute_query);

    if ($attribute_query_run) {
        $_SESSION['message'] = "Thêm thuộc tính thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./attribute.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./add-attribute.php");
        exit();
    }
}
// ============================================================== EDIT ATTRIBUTE =======================================================
else if (isset($_POST['update_attribute_btn'])) {
    $attributeId = $_POST['attributeId'];
    $attributeName = $_POST['attributeName'];
    $attributeStatus = isset($_POST['attributeStatus']) ? '1' : '0';


    $update_query = "UPDATE attributes
SET attributeName='$attributeName',
attributeStatus='$attributeStatus',
create_at=NOW()
WHERE attributeId='$attributeId'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Cập nhật thuộc tính thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./attribute.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./edit-attribute.php?attributeId=$attributeId");
        exit();
    }
}
// ============================================================== DELETE ATTRIBUTE =======================================================
else if (isset($_POST['delete_attribute_btn'])) {
    $attributeId = mysqli_real_escape_string($conn, $_POST['attributeId']);


    // Tiến hành xóa thuộc tính
    $attribute_query = "SELECT * FROM attributes WHERE attributeId='$attributeId'";
    $attribute_query_run = mysqli_query($conn, $attribute_query);
    $attribute_data = mysqli_fetch_array($attribute_query_run);

    $delete_query = "DELETE FROM attributes WHERE attributeId='$attributeId'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        $_SESSION['message'] = "Xóa thuộc tính thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./attribute.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi khi xóa thuộc tính";
        $_SESSION['msg_type'] = "error";
        header("Location: ./attribute.php");
        exit();
    }
}
// ================================================================ ACTION BLOG ========================================================
function generateBlogImageName($prefix = "BLOG")
{
    return $prefix . "_" . date("dmYHis");
}
// ============================================================== ADD BLOG =======================================================
if (isset($_POST['add_blog_btn'])) {
    $blogTitle = $_POST['blogTitle'];
    $blogSlug = $_POST['blogSlug'] . "-" . rand(10, 99);
    $blogDescription = $_POST['blogDescription'];
    $blogContent = $_POST['blogContent'];
    $blogStatus = isset($_POST['blogStatus']) ? '1' : '0';
    $image = $_FILES['blogImage']['name'];
    $path = "../images";
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    if ($image != "") {
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $filename = generateBlogImageName() . '.' . $image_ext;
    } else {
        $filename = "";
    }

    $query = "INSERT INTO blogs (blogTitle, blogSlug, blogImage, blogDescription, blogContent, create_at, blogStatus, categoryId)
VALUES ('$blogTitle', '$blogSlug','$filename', '$blogDescription', '$blogContent', NOW(), '$blogStatus','$categoryId')";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if ($image != "") {
            move_uploaded_file($_FILES['blogImage']['tmp_name'], $path . '/' . $filename);
        }
        $_SESSION['message'] = "Thêm bài viết thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./blog.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./add-blog.php");
        exit();
    }
}
// ============================================================== EDIT BLOG =======================================================
else if (isset($_POST['update_blog_btn'])) {
    $blogId = $_POST['blogId'];
    $blogTitle = $_POST['blogTitle'];
    $blogSlug = $_POST['blogSlug'];
    $blogDescription = $_POST['blogDescription'];
    $blogContent = isset($_POST['blogContent']) ? mysqli_real_escape_string($conn, $_POST['blogContent']) : '';
    $blogStatus = isset($_POST['blogStatus']) ? '1' : '0';
    $new_image = $_FILES['blogImage']['name'];
    $old_image = $_POST['old_image'];
    $path = "../images";
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = generateBlogImageName() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $update_query = "UPDATE blogs
        SET blogTitle='$blogTitle',
        blogSlug='$blogSlug',
        blogImage='$update_filename',
        blogDescription='$blogDescription',
        blogContent='$blogContent',
        create_at=NOW(),
        blogStatus='$blogStatus',
        categoryId='$categoryId'
        WHERE blogId='$blogId'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($new_image != "") {
            move_uploaded_file($_FILES['blogImage']['tmp_name'], $path . '/' . $update_filename);

            if (file_exists($path . "/" . $old_image) && $old_image != "") {
                unlink($path . "/" . $old_image);
            }
        }
        $_SESSION['message'] = "Cập nhật bài viết thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./blog.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./edit-blog.php?blogId=$blogId");
        exit();
    }
}
// ============================================================== DELETE BLOG =======================================================
else if (isset($_POST['delete_blog_btn'])) {
    $blogId = mysqli_real_escape_string($conn, $_POST['blogId']);

    $blog_query = "SELECT * FROM blogs WHERE blogId='$blogId'";
    $blog_query_run = mysqli_query($conn, $blog_query);
    $blog_data = mysqli_fetch_array($blog_query_run);
    $image = $blog_data['blogImage'];

    $delete_query = "DELETE FROM blogs WHERE blogId='$blogId'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../images/" . $image)) {
            unlink("../images/" . $image);
        }
        $_SESSION['message'] = "Xóa bài viết thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./blogs.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi khi xóa bài viết";
        $_SESSION['msg_type'] = "error";
        header("Location: ./blogs.php");
        exit();
    }
}

// ============================================================ ACTION PRODUCT LINE ====================================================
// ============================================================== ADD PRODUCT LINE =======================================================
if (isset($_POST['add_productLine_btn'])) {
    $productLineName = $_POST['productLineName'];
    $productLineDescription = $_POST['productLineDescription'];
    $productLineStatus = isset($_POST['productLineStatus']) ? '1' : '0';
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    $proline_query = "INSERT INTO productlines (productLineName, productLineDescription, productLineStatus, create_at, categoryId)
VALUES ('$productLineName', '$productLineDescription', '$productLineStatus', NOW(), '$categoryId')";

    $proline_query_run = mysqli_query($conn, $proline_query);

    if ($proline_query_run) {
        $_SESSION['message'] = "Thêm dòng sản phẩm thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./productLine.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./add-productLine.php");
        exit();
    }
}
// ============================================================== EDIT PRODUCT LINE =======================================================
else if (isset($_POST['update_productLine_btn'])) {
    $productLineId = $_POST['productLineId'];
    $productLineName = $_POST['productLineName'];
    $productLineDescription = $_POST['productLineDescription'];
    $productLineStatus = isset($_POST['productLineStatus']) ? '1' : '0';
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    $update_query = "UPDATE productlines SET productLineName='$productLineName', productLineDescription='$productLineDescription', 
    productLineStatus='$productLineStatus', create_at=NOW(),categoryId='$categoryId' WHERE productLineId='$productLineId'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Cập nhật dòng sản phẩm thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./productLine.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi";
        $_SESSION['msg_type'] = "error";
        header("Location: ./edit-productLine.php?productLineId=$productLineId");
        exit();
    }
}
// ============================================================== DELETE PRODUCT LINE =======================================================
else if (isset($_POST['delete_productLine_btn'])) {
    $productLineId = mysqli_real_escape_string($conn, $_POST['productLineId']);

    $productLine_query = "SELECT * FROM productlines WHERE productLineId='$productLineId'";
    $productLine_query_run = mysqli_query($conn, $productLine_query);
    $productLine_data = mysqli_fetch_array($productLine_query_run);

    $delete_query = "DELETE FROM productlines WHERE productLineId='$productLineId'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        $_SESSION['message'] = "Xóa dòng sản phẩm thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: ./productLine.php");
        exit();
    } else {
        $_SESSION['message'] = "Đã xảy ra lỗi khi xóa dòng sản phẩm";
        $_SESSION['msg_type'] = "error";
        header("Location: ./productLine.php");
        exit();
    }
}
// ============================================================== ACTION PRODUCT =======================================================
// ============================================================== ADD PRODUCT =======================================================
else if (isset($_POST['add_product_btn'])) {
    $productName = $_POST['productName'];
    $productLineId = $_POST['productLineId'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    $productStatus = isset($_POST['productStatus']) ? '1' : '0';

    // Kiểm tra nếu tất cả các trường bắt buộc không trống
    if ($productName != "") {
        // Thực hiện truy vấn INSERT
        $product_query = "INSERT INTO products (productId, productName, productLineId, categoryId, productStatus, create_at, description) VALUES
        ('$productId', '$productName', '$productLineId', '$categoryId', '$productStatus', NOW(), '$description')";


        $product_query_run = mysqli_query($conn, $product_query);

        if ($product_query_run) {

            // Redirect nếu thành công
            $_SESSION['message'] = "Thêm sản phẩm thành công";
            $_SESSION['msg_type'] = "success";
            header("Location: ./products.php");
            exit();
        } else {
            // Redirect nếu có lỗi trong quá trình lưu sản phẩm
            $_SESSION['message'] = "Đã xảy ra lỗi khi thêm sản phẩm";
            $_SESSION['msg_type'] = "success";
            header("Location: ./add-product.php");
            exit();
        }
    } else {
        // Redirect nếu không điền đủ thông tin
        $_SESSION['message'] = "Bạn chưa điền đủ thông tin";
        $_SESSION['msg_type'] = "success";
        header("Location: ./add-product.php");
        exit();
    }
}
// ============================================================== EDIT PRODUCT  =======================================================
if (isset($_POST['update_product_btn'])) {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productLineId = $_POST['productLineId'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    $productStatus = isset($_POST['productStatus']) ? '1' : '0';

    // Kiểm tra nếu tất cả các trường bắt buộc không trống
    if ($productName != "") {
        // Cập nhật thông tin sản phẩm
        $update_query = "UPDATE products SET productName='$productName', productLineId='$productLineId', categoryId='$categoryId', productStatus='$productStatus', create_at=NOW(), description='$description' WHERE productId='$productId'";
        $update_query_run = mysqli_query($conn, $update_query);

        if ($update_query_run) {
            $_SESSION['message'] = "Cập nhật sản phẩm thành công";
            $_SESSION['msg_type'] = "success";
            header("Location: ./products.php");
            exit();
        } else {
            $_SESSION['message'] = "Đã xảy ra lỗi khi cập nhật sản phẩm";
            $_SESSION['msg_type'] = "error";
            header("Location: ./edit-product.php?productId=$productId");
            exit();
        }
    } else {
        $_SESSION['message'] = "Bạn chưa điền đủ thông tin";
        $_SESSION['msg_type'] = "warning";
        header("Location: ./edit-product.php?productId=$productId");
        exit();
    }
}
// ============================================================== DELETE PRODUCT =======================================================
if (isset($_POST['delete_product_btn'])) {
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);

    // Kiểm tra xem có biến thể nào của sản phẩm nằm trong đơn hàng không
    $check_query = "
        SELECT po.productOrderId
        FROM productorders po
        JOIN productvariants pv ON po.productVariantId = pv.productVariantId
        WHERE pv.productId = '$productId'
        LIMIT 1
    ";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Có biến thể của sản phẩm đang nằm trong đơn hàng
        $_SESSION['message'] = "Không thể xóa sản phẩm vì có biến thể đang được sử dụng trong đơn hàng";
        $_SESSION['msg_type'] = "error";
    } else {
        // Không có biến thể nào đang trong đơn hàng → được phép xóa
        $delete_query = "DELETE FROM products WHERE productId = '$productId'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            $_SESSION['message'] = "Xóa sản phẩm thành công";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Đã xảy ra lỗi khi xóa sản phẩm";
            $_SESSION['msg_type'] = "error";
        }
    }

    header("Location: ./products.php");
    exit();
}

// ============================================================== EDIT PRODUCT ATTRIBUTE =======================================================
if (isset($_POST['update_product_attribute_btn'])) {
    $productId = $_POST['productId'];
    $attributeIds = $_POST['attributeId'];
    $attributeValues = $_POST['attributeValue'];

    // Kiểm tra xem có dữ liệu không
    if (!empty($attributeIds) && !empty($attributeValues)) {
        $errors = [];
        for ($i = 0; $i < count($attributeIds); $i++) {
            $attributeId = $attributeIds[$i];
            $attributeValue = $attributeValues[$i];

            if (!empty($attributeValue)) { // Kiểm tra giá trị không rỗng
                $update_query = "UPDATE productattributes SET attributeValue = '$attributeValue', create_at=NOW() WHERE productId = $productId AND attributeId = $attributeId";
                $update_query_run = mysqli_query($conn, $update_query);

                if (!$update_query_run) {
                    $errors[] = "Lỗi khi cập nhật thuộc tính ID: $attributeId";

                }
            }
        }

        if (empty($errors)) {

        } else {
            $_SESSION['message'] = "Lỗi khi cập nhật thông tin sản phẩm";
            $_SESSION['msg_type'] = "error";
            header("Location: ./edit-product-information.php?productId=$productId");
            exit();
        }
    } else {
        $_SESSION['message'] = "Bạn chưa điền đủ thông tin";
        $_SESSION['msg_type'] = "warning";
        header("Location: ./edit-product-information.php?productId=$productId");
        exit();
    }
}
// ============================================================== ADD PRODUCT ATTRIBUTE =======================================================
if (isset($_POST['add_info_product_btn'])) {
    $productId = $_POST['productId']; // Lấy ID sản phẩm
    $attributeIds = $_POST['attributeId'];
    $attributeValues = $_POST['attributeValue'];

    // Kiểm tra nếu tất cả các trường bắt buộc không trống
    if (!empty($productId) && !empty($attributeIds) && !empty($attributeValues)) {
        foreach ($attributeIds as $index => $attributeId) {
            $attributeValue = $attributeValues[$index];

            if (!empty($attributeId) && !empty($attributeValue)) {
                // Kiểm tra xem sản phẩm đã có thuộc tính chưa
                $check_query = "SELECT * FROM productAttributes WHERE productId = '$productId' AND attributeId = '$attributeId'";
                $check_result = mysqli_query($conn, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    // Nếu đã có, thực hiện UPDATE
                    $query = "UPDATE productAttributes SET attributeValue = '$attributeValue', create_at=NOW() WHERE productId = '$productId' AND attributeId = '$attributeId'";
                } else {
                    // Nếu chưa có, thực hiện INSERT
                    $query = "INSERT INTO productAttributes (productId, attributeId, attributeValue, create_at) VALUES ('$productId', '$attributeId', '$attributeValue', NOW())";
                }

                $query_run = mysqli_query($conn, $query);
            }
        }

        $_SESSION['message'] = "Cập nhật thông tin sản phẩm thành công!";
        $_SESSION['msg_type'] = "success";
        header("Location: ./product-information.php?productId=" . $productId);
        exit();
    } else {
        $_SESSION['message'] = "Vui lòng nhập đầy đủ thông tin!";
        $_SESSION['msg_type'] = "warning";
        header("Location: ./product-information.php?productId=" . $productId);
        exit();
    }


}
// ============================================================== ADD PRODUCT VARIANT =======================================================
if (isset($_POST['add_product_variant_btn'])) {
    // Nhận dữ liệu từ form
    $price = $_POST['price'];
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];

    // Xử lý danh sách thuộc tính
    $attributeValueIds = $_POST['attributeValueId']; // Mảng các ID thuộc tính
    $attributeValues = $_POST['attributeValue']; // Mảng giá trị thuộc tính

    $attributeFileIds = $_POST['attributeFileId'] ?? []; // Mảng các ID thuộc tính ảnh phụ, khởi tạo là mảng rỗng nếu không tồn tại
    $attributeFiles = $_FILES['attributeFile'] ?? []; // Mảng giá trị thuộc tính ảnh phụ

    // Kiểm tra và hiển thị giá trị
    if (isset($attributeValueIds[0], $attributeValues[0], $attributeFileIds[0], $attributeFiles['name'][0])) {
        echo "{$attributeValueIds[0]}, {$attributeValues[0]}, {$attributeFileIds[0]}, {$attributeFiles['name'][0]}";
    } else {
        echo "Dữ liệu không hợp lệ hoặc không tồn tại.";
    }

    // Xử lý ảnh chính
    $productVariantImage = $_FILES['productVariantImage']['name'];
    $imageTmpName = $_FILES['productVariantImage']['tmp_name'];
    $extension = pathinfo(basename($productVariantImage), PATHINFO_EXTENSION);

    // Tạo tên ảnh từ productName và thuộc tính
    $string = $productName;
    foreach ($attributeValues as $value) {
        $string .= " $value";
    }

    // Chuyển thành chữ thường và tạo tên file
    $string = mb_strtolower($string, 'UTF-8');
    $string = preg_replace('/\s+/', '-', $string);
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    $string = trim($string, '-');
    $imageName = "$string.$extension";

    // Lấy đường dẫn lưu ảnh
    $query1 = "SELECT categoryName FROM categories 
               JOIN products ON products.categoryId = categories.categoryId 
               WHERE productId = $productId";
    $result1 = mysqli_query($conn, $query1);

    if (!$result1 || mysqli_num_rows($result1) == 0) {
        die("Không tìm thấy danh mục cho sản phẩm này!");
    }

    $row = mysqli_fetch_assoc($result1);
    $categoryFolder = $row['categoryName'];

    // Lấy số từ productName để tạo thư mục riêng
    preg_match('/\d+/', $productName, $matches);
    $productFolder = isset($matches[0]) ? $categoryFolder . $matches[0] : $categoryFolder;

    // Đường dẫn thư mục và ảnh
    $folderPath = "../images/$categoryFolder/$productFolder/";
    $imagePath = $folderPath . $imageName;

    // Kiểm tra & tạo thư mục nếu chưa tồn tại
    if (!file_exists($folderPath)) {
        if (!mkdir($folderPath, 0777, true)) {
            die("Không thể tạo thư mục: $folderPath");
        }
    }

    // Di chuyển file tải lên vào thư mục đích
    if (!move_uploaded_file($imageTmpName, $imagePath)) {
        die("Tải lên thất bại! Kiểm tra quyền thư mục.");
    }

    // Thêm vào bảng productvariants
    $query2 = "INSERT INTO productvariants (productId, productVariantImage, price, create_at) 
                VALUES ('$productId', '$categoryFolder/$productFolder/$imageName', '$price', NOW())";
    $result2 = mysqli_query($conn, $query2);
    if (!$result2) {
        die("Lỗi khi thêm biến thể: " . mysqli_error($conn));
    }

    $productVariantId = mysqli_insert_id($conn); // Lấy ID biến thể vừa tạo

    // Thêm thuộc tính vào bảng productvariantattributes
    foreach ($attributeValueIds as $index => $attributeValueId) {
        $attributeValue = mysqli_real_escape_string($conn, $attributeValues[$index]);

        // Thêm vào bảng productvariantattributes
        $query2 = "INSERT INTO productvariantattributes (productVariantId, attributeId, attributeValue, create_at) 
                    VALUES ('$productVariantId', '$attributeValueId', '$attributeValue', NOW())";
        if (!mysqli_query($conn, $query2)) {
            die("Lỗi khi thêm thuộc tính: " . mysqli_error($conn));
        }
    }

    // Thêm thuộc tính ảnh phụ vào bảng productvariantattributes
    foreach ($attributeFileIds as $index => $attributeFileId) {
        $attributeFile = mysqli_real_escape_string($conn, $attributeFiles[$index]);

        // Tải ảnh lên local
        $fileTmpName = $attributeFiles['tmp_name'][$index];
        $extension = pathinfo(basename($attributeFiles['name'][$index]), PATHINFO_EXTENSION);
        $fileName = "$string-" . $index + 1 . ".$extension"; // Tạo tên file cho ảnh thuộc tính

        // Di chuyển file tải lên
        if (!move_uploaded_file($fileTmpName, $folderPath . $fileName)) {
            die("Tải lên ảnh thuộc tính thất bại!");
        }

        // Thêm vào bảng productvariantattributes
        $query2 = "INSERT INTO productvariantattributes (productVariantId, attributeId, attributeValue, create_at) 
                    VALUES ('$productVariantId', '$attributeFileId', '$categoryFolder/$productFolder/$fileName', NOW())";
        if (!mysqli_query($conn, $query2)) {
            die("Lỗi khi thêm thuộc tính: " . mysqli_error($conn));
        }
    }

    // Hiển thị thông báo thành công
    $_SESSION['message'] = "Thêm biến thể thành công!";
    $_SESSION['msg_type'] = "success";
    header("Location: ./product-information.php?productId=$productId");
    exit();
}
// ============================================================== UPDATE PRODUCT SUBIMAGE VARIANT =======================================================


if (isset($_POST['update_product_subImage_variant_btn'])) {
    $productVariantId = $_POST['productVariantId'];
    $productId = $_POST['productId'];

    // Lấy thông tin ảnh phụ
    $attributeIds = $_POST['attributeId'];
    $oldAttributeValues = $_POST['oldAttributeValue'] ?? [];
    $attributeFiles = $_FILES['attributeFile'] ?? [];

    // Lấy danh sách tên thuộc tính từ cơ sở dữ liệu
    $attrQuery = "SELECT attributeId, attributeName FROM attributes WHERE attributeId IN (" . implode(',', $attributeIds) . ")";
    $attrsResult = mysqli_query($conn, $attrQuery);
    $attributeNames = [];
    while ($row = mysqli_fetch_assoc($attrsResult)) {
        $attributeNames[$row['attributeId']] = $row['attributeName'];
    }

    // Lấy thông tin thư mục lưu ảnh
    $query1 = "SELECT categoryName FROM categories 
               JOIN products ON products.categoryId = categories.categoryId 
               WHERE productId = $productId";
    $result1 = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result1);
    $categoryFolder = $row['categoryName'];

    // Tạo tên thư mục từ tên sản phẩm
    preg_match('/\d+/', $_POST['productName'], $matches);
    $productFolder = isset($matches[0]) ? $categoryFolder . $matches[0] : $categoryFolder;
    $folderPath = "../images/$categoryFolder/$productFolder/";
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Chuẩn bị phần tên file cơ bản
    $productNameSlug = preg_replace('/[^a-z0-9]/u', '', mb_strtolower($_POST['productName'], 'UTF-8'));
    $categorySlug = preg_replace('/[^a-z0-9]/u', '', mb_strtolower($categoryFolder, 'UTF-8'));
    $timestamp = date("Ymd-His"); // Định dạng: 20250405-153210

    // === Xử lý ảnh chính ===
    if (isset($_FILES['productVariantImage']) && $_FILES['productVariantImage']['error'] === UPLOAD_ERR_OK) {
        $productVariantImage = $_FILES['productVariantImage']['name'];
        $imageTmpName = $_FILES['productVariantImage']['tmp_name'];
        $extension = pathinfo($productVariantImage, PATHINFO_EXTENSION);

        $newImageName = "{$productNameSlug}-{$categorySlug}-{$timestamp}.{$extension}";
        $imagePath = $folderPath . $newImageName;

        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            die("Tải ảnh chính thất bại.");
        }

        // Cập nhật đường dẫn ảnh chính
        $imgCol = "$categoryFolder/$productFolder/$newImageName";
        $updateQuery = "UPDATE productvariants 
                        SET productVariantImage = '$imgCol' 
                        WHERE productVariantId = $productVariantId";
        if (!mysqli_query($conn, $updateQuery)) {
            die("Lỗi khi cập nhật ảnh chính: " . mysqli_error($conn));
        }
    }

    // === Xử lý ảnh phụ ===
    foreach ($attributeIds as $index => $attrId) {
        $isImage = (isset($attributeNames[$attrId]) && strtolower($attributeNames[$attrId]) === 'Ảnh phụ');
        if ($isImage) {
            $hasNewFile = isset($attributeFiles['name'][$index]) && $attributeFiles['error'][$index] === UPLOAD_ERR_OK;

            if ($hasNewFile) {
                $extension = pathinfo($attributeFiles['name'][$index], PATHINFO_EXTENSION);
                $fileTmpName = $attributeFiles['tmp_name'][$index];
                $fileName = "{$productNameSlug}-{$categorySlug}-{$timestamp}-sub{$index}.{$extension}";

                if (!move_uploaded_file($fileTmpName, $folderPath . $fileName)) {
                    die("Tải lên ảnh phụ thất bại!");
                }

                $attrValue = "$categoryFolder/$productFolder/$fileName";
                $query = "UPDATE productvariantattributes 
                          SET attributeValue = '$attrValue' 
                          WHERE productVariantAttributeId = {$_POST['productVariantAttributeId'][$index]}";
                if (!mysqli_query($conn, $query)) {
                    die("Lỗi cập nhật ảnh phụ: " . mysqli_error($conn));
                }
            } else {
                // Nếu không có ảnh mới thì giữ nguyên giá trị cũ
                $oldValue = $oldAttributeValues[$index] ?? '';
                $query = "UPDATE productvariantattributes 
                          SET attributeValue = '$oldValue' 
                          WHERE productVariantAttributeId = {$_POST['productVariantAttributeId'][$index]}";
                if (!mysqli_query($conn, $query)) {
                    die("Lỗi cập nhật ảnh phụ: " . mysqli_error($conn));
                }
            }
        }
    }

    $_SESSION['message'] = "Cập nhật ảnh thành công!";
    $_SESSION['msg_type'] = "success";
    header("Location: ./product-information.php?productId=$productId");
    exit();
}

// ============================================================== UPDATE PRODUCT INFORMATION VARIANT =======================================================


if (isset($_POST['update_product_information_variant_btn'])) {
    $productVariantId = $_POST['productVariantId'];
    $productId = $_POST['productId'];
    $price = $_POST['price'];
    $productStatus = isset($_POST['productVariantStatus']) ? '1' : '0';

    // Cập nhật giá và trạng thái trong bảng productvariants
    $updateVariantQuery = "UPDATE productvariants SET price = ?, productVariantStatus = ? WHERE productVariantId = ?";
    $stmt = $conn->prepare($updateVariantQuery);
    $stmt->bind_param("dsi", $price, $productStatus, $productVariantId);
    $variantUpdated = $stmt->execute();
    $stmt->close();

    // Cập nhật các thuộc tính trong bảng productvariantattributes
    $attributeIds = $_POST['attributeId'];
    $attributeValues = $_POST['attributeValue'];
    $productVariantAttributeIds = $_POST['productVariantAttributeId'];

    $allAttributesUpdated = true;

    if (
        count($attributeIds) === count($attributeValues) &&
        count($attributeIds) === count($productVariantAttributeIds)
    ) {
        for ($i = 0; $i < count($attributeIds); $i++) {
            $updateAttrQuery = "UPDATE productvariantattributes 
                                SET attributeValue = ? 
                                WHERE productVariantAttributeId = ? AND attributeId = ? AND productVariantId = ?";
            $stmt = $conn->prepare($updateAttrQuery);
            $stmt->bind_param("siii", $attributeValues[$i], $productVariantAttributeIds[$i], $attributeIds[$i], $productVariantId);
            if (!$stmt->execute()) {
                $allAttributesUpdated = false;
                $stmt->close();
                break;
            }
            $stmt->close();
        }
    } else {
        $allAttributesUpdated = false;
    }

    // Kiểm tra kết quả
    if ($variantUpdated && $allAttributesUpdated) {
        $_SESSION['message'] = "Cập nhật biến thể sản phẩm thành công.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật biến thể sản phẩm.";
        $_SESSION['msg_type'] = "error";
    }

    header("Location: ./product-information.php?productId=$productId");
    exit();
}


// ============================================================== DELETE PRODUCT VARIANT =======================================================

if (isset($_POST['delete_product_variant_btn'])) {
    $productVariantId = mysqli_real_escape_string($conn, $_POST['productVariantId']);
    $productId = mysqli_real_escape_string($conn, $_POST['productId']);

    // Kiểm tra xem biến thể có tồn tại trong đơn hàng hay không
    $check_query = "SELECT 1 FROM productOrders WHERE productVariantId = '$productVariantId' LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu có đơn hàng chứa biến thể
        $_SESSION['message'] = "Không thể xóa biến thể vì có đơn hàng chứa sản phẩm đó";
        $_SESSION['msg_type'] = "error";
        header("Location: ./product-information.php?productId=$productId");
        exit();
    } else {
        // Xóa biến thể nếu không có đơn hàng chứa nó
        $delete_query = "DELETE FROM productvariants WHERE productVariantId = '$productVariantId'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            $_SESSION['message'] = "Xóa biến thể thành công";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Đã xảy ra lỗi khi xóa biến thể";
            $_SESSION['msg_type'] = "error";
        }

        header("Location: ./product-information.php?productId=$productId");
        exit();
    }
}


// ============================================================== ADD DISCOUNT =======================================================
if (isset($_POST['add_discount_btn'])) {
    $discountName = $_POST['discountName'];
    $discountSlug = $_POST['discountSlug'];
    $discountDescription = $_POST['discountDescription'];
    $discountPercentage = $_POST['discountPercentage'];
    $discountStartDate = $_POST['discountStartDate'];
    $discountEndDate = $_POST['discountEndDate'];

    // Kiểm tra nếu các trường không trống
    if ($discountName != "" && $discountSlug != "" && $discountDescription != "" && $discountPercentage != "" && $discountStartDate != "" && $discountEndDate != "") {
        // Thực hiện truy vấn INSERT
        $query = "INSERT INTO discounts 
                    (discountName, discountSlug, discountDescription, discountPercentage, discountStartDate, discountEndDate, create_at)
                  VALUES 
                    ('$discountName', '$discountSlug', '$discountDescription', '$discountPercentage', '$discountStartDate', '$discountEndDate', NOW())";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Thêm khuyến mãi thành công";
            $_SESSION['msg_type'] = "success";
            header("Location: discount.php");
            exit();
        } else {
            $_SESSION['message'] = "Đã xảy ra lỗi khi thêm khuyến mãi";
            $_SESSION['msg_type'] = "error";
            header("Location: add-discount.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Bạn chưa điền đủ thông tin";
        $_SESSION['msg_type'] = "warning";
        header("Location: add-discount.php");
        exit();
    }
}

// ============================================================== EDIT DISCOUNT =======================================================
if (isset($_POST['update_discount_btn'])) {
    $discountId = $_POST['discountId'];
    $discountName = $_POST['discountName'];
    $discountSlug = $_POST['discountSlug'];
    $discountDescription = $_POST['discountDescription'];
    $discountPercentage = $_POST['discountPercentage'];
    $discountStartDate = $_POST['discountStartDate'];
    $discountEndDate = $_POST['discountEndDate'];

    if ($discountName != "" && $discountSlug != "" && $discountDescription != "" && $discountPercentage != "" && $discountStartDate != "" && $discountEndDate != "") {
        $query = "UPDATE discounts SET 
                    discountName = '$discountName',
                    discountSlug = '$discountSlug',
                    discountDescription = '$discountDescription',
                    discountPercentage ='$discountPercentage',
                    discountStartDate = '$discountStartDate',
                    discountEndDate = '$discountEndDate'
                  WHERE discountId = '$discountId'";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Cập nhật khuyến mãi thành công";
            $_SESSION['msg_type'] = "success";
            header("Location: discount.php");
            exit();
        } else {
            $_SESSION['message'] = "Cập nhật thất bại";
            $_SESSION['msg_type'] = "error";
            header("Location: edit-discount.php?discountId=$discountId");
            exit();
        }
    } else {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin";
        $_SESSION['msg_type'] = "warning";
        header("Location: edit-discount.php?discountId=$discountId");
        exit();
    }
}

// ============================================================== DELETE DISCOUNT =======================================================
if (isset($_POST['delete_discount_btn'])) {
    $discountId = $_POST['discountId'];

    // Thực hiện truy vấn DELETE
    $query = "DELETE FROM discounts WHERE discountId = '$discountId'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Xóa khuyến mãi thành công";
        $_SESSION['msg_type'] = "success";
        header("Location: discount.php");
        exit();
    } else {
        $_SESSION['message'] = "Xóa khuyến mãi thất bại";
        $_SESSION['msg_type'] = "danger";
        header("Location: discount.php");
        exit();
    }
}
?>