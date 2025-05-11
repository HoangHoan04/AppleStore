<?php
include("./config/db_connection.php");
function getCategoryAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE categoryStatus='1'";
    return $query_run = mysqli_query($conn, $query);
}
function getBlogsByCategoryId($table, $categoryId)
{
    global $conn;
    $categoryId = mysqli_real_escape_string($conn, $categoryId);
    $sql = "SELECT * FROM $table WHERE blogStatus = 1 AND categoryId = $categoryId ORDER BY create_at DESC";
    return mysqli_query($conn, $sql);
}

function getBlogAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE blogStatus='1'";
    return $query_run = mysqli_query($conn, $query);
}

function getSliderAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE sliderStatus='1'";
    return $query_run = mysqli_query($conn, $query);
}



function getUserByID($table, $userId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE userId='$userId'";
    return $query_run = mysqli_query($conn, $query);
}

function getIDActive($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id' AND status='0'";
    return $query_run = mysqli_query($conn, $query);
}
function getByID($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id'";
    return $query_run = mysqli_query($conn, $query);
}
function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($conn, $query);
}

function totalValue($table)
{
    global $conn;
    $query = "SELECT COUNT(*) as `number` FROM $table";
    $totalValue = mysqli_query($conn, $query);
    $totalValue = mysqli_fetch_array($totalValue);
    return $totalValue['number'];
}

















function getProductLineByCategory($categoryName)
{
    global $conn;
    $query = "SELECT * FROM productlines 
              WHERE categoryId = (SELECT categoryId FROM categories WHERE categoryName = ? LIMIT 1) 
              AND productLineStatus = 1"; // Thêm điều kiện productLineStatus = 1
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $categoryName); // Liên kết tham số categoryName
    $stmt->execute();
    return $stmt->get_result(); // Trả về kết quả truy vấn
}

function getSliderByCategory($categoryName)
{
    global $conn;
    $query = "SELECT sliderImage, sliderTitle FROM sliders WHERE categoryId = (SELECT categoryId FROM categories WHERE categoryName = ? LIMIT 1) AND sliderStatus = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $categoryName); // Liên kết tham số categoryName
    $stmt->execute();
    return $stmt->get_result(); // Trả về kết quả truy vấn
}
function getCategoryLogoByCategory($categoryName)
{
    global $conn;
    $query = "SELECT categoryLogo FROM categories WHERE categoryName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $categoryName); // Liên kết tham số categoryName
    $stmt->execute();
    return $stmt->get_result(); // Trả về kết quả truy vấn
}

?>