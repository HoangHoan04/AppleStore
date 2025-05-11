<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../config/db_connection.php"); // Kết nối CSDL

// Đọc dữ liệu gửi từ JS
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra xem dữ liệu có hợp lệ không
if (!isset($data['paymentMethod'], $data['userName'], $data['userPhone'], $data['userEmail'], $data['cartItems'])) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ!"]);
    exit();
}

// Gán các biến
$paymentMethod = $data['paymentMethod'];
$userName = $data['userName'];
$userPhone = $data['userPhone'];
$userEmail = $data['userEmail'];
$orderPrice = $data['orderPrice'];
$discountId = $data['discountId'];
$cartItems = $data['cartItems'];
$note = $data['note'];
$orderCity = $data['orderCity'];
$orderDistrict = $data['orderDistrict'];
$orderWard = $data['orderWard'];
$orderAddress = $data['orderAddress'];
$orderMethod = $data['orderMethod'];

// Giả sử userId bạn lấy từ session
session_start();
$userId = $_SESSION['userId'] ?? 1; // test cứng 1 nếu chưa có session

$orderQuantity = 0;

// Tính tổng giá và số lượng từ giỏ hàng
foreach ($cartItems as $item) {
    $orderQuantity += $item['quantity'];
}

$createAt = date("Y-m-d H:i:s");
$orderStatus = 1; // mặc định chưa duyệt
$orderPaymentStatus = 1; // chưa thanh toán

if($paymentMethod != 1) {
    $orderPaymentStatus = 2;
}

try {
    $conn->begin_transaction();

    // Insert đơn hàng
    $stmt = $conn->prepare("INSERT INTO orders (orderPrice, orderStatus, orderQuantity, orderPaymentStatus, orderPaymentMethod, create_at, discountId, userId, orderCity, orderDistrict, orderWard, orderAddress, orderMethod) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiisiiiiisi", $orderPrice, $orderStatus, $orderQuantity, $orderPaymentStatus, $paymentMethod, $createAt, $discountId, $userId, $orderCity, $orderDistrict, $orderWard, $orderAddress, $orderMethod);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Insert chi tiết từng sản phẩm
    foreach ($cartItems as $item) {
        // Insert vào orderdetails
        $stmt = $conn->prepare("INSERT INTO orderdetails (orderDetailQuantity, orderDetailPrice, orderId) VALUES (?, ?, ?)");
        $stmt->bind_param("idi", $item['quantity'], $item['price'], $orderId);
        $stmt->execute();
        $orderDetailId = $stmt->insert_id; // Lưu lại ID của orderDetail vừa chèn
        $stmt->close();

        // Insert vào productorders
        $stmt = $conn->prepare("INSERT INTO productorders (productOrderPrice, productOrderImage, productOrderDescription, orderDetailId, productVariantId) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $item['price'], $item['image'], $note, $orderDetailId, $item["productVariantId"]);
        $stmt->execute();
        $stmt->close();
    }

    $conn->commit();

    echo json_encode(["success" => true, "orderId" => $orderId]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
