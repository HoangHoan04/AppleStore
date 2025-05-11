<?php
include('../config/db_connection.php');
// ====================== SELECT ALL ================================
function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($conn, $query);
}

//==================== SELECT QUERY TABLE ======================== 
function getUserByID($table, $userId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE userId='$userId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdCategory($table, $categoryId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE categoryId='$categoryId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdSlider($table, $sliderId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE sliderId='$sliderId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdUser($table, $userId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE userId='$userId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdAttribute($table, $attributeId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE attributeId='$attributeId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdBlog($table, $blogId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE blogId='$blogId'";
    return $query_run = mysqli_query($conn, $query);
}


function getByIdProductLine($table, $productLineId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE productLineId='$productLineId'";
    return $query_run = mysqli_query($conn, $query);
}

function getByIdProduct($table, $productId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE productId='$productId'";
    return $query_run = mysqli_query($conn, $query);
}
function getByIdProductVariant($table, $productVariantId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE productVariantId='$productVariantId'";
    return $query_run = mysqli_query($conn, $query);
}

function getByIdProductAttribute($table, $productAttributeId)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE productAttributeId='$productAttributeId'";
    return $query_run = mysqli_query($conn, $query);
}

function getAttributeIdByProductId($productId)
{
    global $conn;
    $query = "SELECT pa.attributeId, a.attributeName, pa.attributeValue 
              FROM productattributes pa
              JOIN attributes a ON pa.attributeId = a.attributeId
              WHERE pa.productId = $productId";
    return mysqli_query($conn, $query);
}

function totalValue($table)
{
    global $conn;
    $query = "SELECT COUNT(*) as `number` FROM $table";
    $totalValue = mysqli_query($conn, $query);
    $totalValue = mysqli_fetch_array($totalValue);
    return $totalValue['number'];
}

function formatCurrencyVND($amount)
{
    return number_format($amount, 0, ',', '.') . '₫';
}

?>