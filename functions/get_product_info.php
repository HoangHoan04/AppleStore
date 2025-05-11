<?php
session_start();
include('../config/db_connection.php'); // Kết nối đến cơ sở dữ liệu

if (isset($_GET['variantId'])) {
    $variantId = (int)$_GET['variantId'];

    $query = "
        SELECT 
        pv.productVariantId, 
        pv.productVariantImage, 
        pv.price, 
        p.productName,
        MAX(CASE WHEN a.attributeName = 'Màu' THEN pva.attributeValue END) AS color, 
        MAX(CASE WHEN a.attributeName = 'Dung lượng' THEN pva.attributeValue END) AS storage
        FROM productvariants pv 
        JOIN products p ON pv.productId = p.productId 
        LEFT JOIN productVariantAttributes pva ON pv.productVariantId = pva.productVariantId
        LEFT JOIN attributes a ON pva.attributeId = a.attributeId
        WHERE pv.productVariantId = ?
        GROUP BY pv.productVariantId;
        ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $variantId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Không tìm thấy sản phẩm.']);
    }
} else {
    echo json_encode(['error' => 'Mã biến thể không hợp lệ.']);
}
?>
