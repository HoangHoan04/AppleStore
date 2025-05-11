<?php
include("./includes/header.php");
?>

<body class="bg-gray-100">
    <div class="container mx-auto py-10 mt-5">
        <h2 class=" font-bold text-center mb-8">Dịch Vụ Sửa Chữa AppleCare</h2>
        <div class="separator"></div> <!-- Kẻ ngang -->
        <!-- Các bước sửa chữa -->
        <div class="process-container">
            <h4 class="text-center font-semibold">Quy trình bảo hành AppleCare</h4>
            <div class="process-steps">
                <div class="process-step">
                    <div class="process-step-icon">
                        <i class="fa-solid fa-magnifying-glass text-3xl"></i>
                    </div>
                    <span>Kiểm tra tổng quan trước khi sửa chữa</span>
                </div>
                <div class="process-step">
                    <div class="process-step-icon">
                        <i class="fa-solid fa-cart-flatbed"></i>
                    </div>
                    <span>Đặt linh kiện</span>
                </div>
                <div class="process-step">
                    <div class="process-step-icon">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <span>Sửa chữa | Thay thế</span>
                </div>
                <div class="process-step">
                    <div class="process-step-icon">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <span>Kiểm tra tổng quan sau khi sửa chữa</span>
                </div>
                <div class="process-step">
                    <div class="process-step-icon">
                        <i class="fa-solid fa-people-carry-box"></i>
                    </div>
                    <span>Giao lại cho khách hàng</span>
                </div>
            </div>
        </div>
        <div class="separator"></div> <!-- Kẻ ngang -->
        <!-- Bảng giá sửa chữa AppleCare -->
        <div class="mt-10">
            <h3 class=" font-semibold text-center mb-4">Bảng Giá Sửa Chữa Apple</h3>
            <table class="min-w-full table-auto bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2 border">Loại Sản Phẩm</th>
                        <th class="px-4 py-2 border">Vấn Đề</th>
                        <th class="px-4 py-2 border">Giá Sửa Chữa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- iPhone -->
                    <tr>
                        <td class="px-4 py-2 border font-semibold" rowspan="10">iPhone</td>
                        <td class="px-4 py-2 border">Thay màn hình</td>
                        <td class="px-4 py-2 border">2.500.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay pin</td>
                        <td class="px-4 py-2 border">900.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa nút home</td>
                        <td class="px-4 py-2 border">600.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay camera trước</td>
                        <td class="px-4 py-2 border">800.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay camera sau</td>
                        <td class="px-4 py-2 border">1.200.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay loa</td>
                        <td class="px-4 py-2 border">500.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay mic</td>
                        <td class="px-4 py-2 border">400.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa lỗi không nhận sạc</td>
                        <td class="px-4 py-2 border">700.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay cáp sạc</td>
                        <td class="px-4 py-2 border">350.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa lỗi Face ID</td>
                        <td class="px-4 py-2 border">2.000.000 VND</td>
                    </tr>

                    <!-- iPad -->
                    <tr>
                        <td class="px-4 py-2 border font-semibold" rowspan="5">iPad</td>
                        <td class="px-4 py-2 border">Thay pin</td>
                        <td class="px-4 py-2 border">1.500.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay màn hình</td>
                        <td class="px-4 py-2 border">2.800.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa cổng sạc</td>
                        <td class="px-4 py-2 border">600.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay loa</td>
                        <td class="px-4 py-2 border">700.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Cập nhật phần mềm</td>
                        <td class="px-4 py-2 border">300.000 VND</td>
                    </tr>

                    <!-- Macbook -->
                    <tr>
                        <td class="px-4 py-2 border font-semibold" rowspan="5">Macbook</td>
                        <td class="px-4 py-2 border">Thay SSD</td>
                        <td class="px-4 py-2 border">2.500.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay bàn phím</td>
                        <td class="px-4 py-2 border">1.800.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Thay pin</td>
                        <td class="px-4 py-2 border">2.200.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa lỗi màn hình</td>
                        <td class="px-4 py-2 border">3.000.000 VND</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">Sửa lỗi mainboard</td>
                        <td class="px-4 py-2 border">4.500.000 VND</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="separator"></div> <!-- Kẻ ngang -->
        <section class="reason-section">
            <h4 class="section-title">Cam kết dịch vụ của AppleCare</h4>
            <div class="reason-grid">
                <div class="reason-item">
                    <div class="icon"><i class="fa-brands fa-apple"></i></div>
                    <h3>Chính hãng Apple</h3>
                    <p>AppleCare là trung tâm dịch vụ ủy quyền chính thức của Apple. Tất cả linh kiện sửa chữa tại
                        AppleCare đều do Apple cung cấp chính hãng.</p>
                </div>
                <div class="reason-item">
                    <div class="icon"><i class="fa-solid fa-medal"></i></div>
                    <h3>Chứng chỉ Apple</h3>
                    <p>100% đội ngũ chuyên viên và kỹ thuật viên của AppleCare được đào tạo và cấp chứng chỉ bởi Apple
                        của Mỹ.
                    </p>
                </div>
                <div class="reason-item">
                    <div class="icon"><i class="fa-solid fa-user-lock"></i></div>
                    <h3>Bảo mật tuyệt đối</h3>
                    <p>Thông tin khách hàng cung cấp được bảo vệ nghiêm ngặt theo tiêu chuẩn kiểm soát cao nhất, đảm bảo
                        bảo mật một cách chính sác</p>
                </div>
                <div class="reason-item">
                    <div class="icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <h3>Kỹ thuật viên chuyên nghiệp</h3>
                    <p>Đội ngũ kỹ thuật viên tại AppleCare có tay nghề cao, nhiều năm kinh nghiệm xử lý mọi vấn đề kỹ
                        thuật từ đơn giản đến phức tạp.</p>
                </div>
                <div class="reason-item">
                    <div class="icon"><i class="fa-solid fa-star"></i></div>
                    <h3>Dịch vụ đẳng cấp</h3>
                    <p>Với phương châm lấy khách hàng làm trọng tâm, AppleCare cam kết mang đến chất lượng phục vụ vượt
                        trội dành cho khách hàng, giúp khách hàng an tâm khi lựa chọn AppleCare</p>
                </div>
                <div class="reason-item">
                    <div class="icon"><i class="fa-solid fa-piggy-bank"></i></div>
                    <h3>Tiết kiệm kinh phí</h3>
                    <p>AppleCare thường xuyên có những chương trình ưu đãi giúp khách hàng tiết kiệm hơn khi sửa chữa
                        sản phẩm, giúp khách hàng tiết kiệm chi phí.</p>
                </div>
            </div>
        </section>


    </div>

</body>

<?php
include("./includes/footer.php");
?>

<style>
    .separator-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .content-before,
    .content-after {
        margin: 10px 0;
        font-size: 1rem;
        color: #333;
    }

    .separator {
        border-top: 2px solid #ccc;
        /* Kẻ đường ngang */
        margin: 20px 0;
    }

    .reason-section {
        background-color: #f8f8f9;
        padding: 60px 20px;
        text-align: center;
    }

    .section-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 40px;
        color: #1a1a1a;
    }

    .reason-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .reason-item {
        background-color: #fff;
        padding: 30px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .reason-item:hover {
        transform: translateY(-5px);
    }

    .reason-item .icon {
        font-size: 40px;
        margin-bottom: 16px;
    }

    .reason-item h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 12px;
        color: #333;
    }

    .reason-item p {
        font-size: 16px;
        color: #666;
        line-height: 1.6;
    }

    /* General styling for the container */
    .process-container {
        margin: 20px;
    }

    /* Style the header */
    .text-xl {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .font-semibold {
        font-weight: 600;
    }

    /* Flex container for the steps */
    .process-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 40px;
        /* Adjust the space between steps */
        margin-top: 20px;
    }

    /* Style for each process step */
    .process-step {
        height: 150px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 150px;
    }

    /* Style for each icon */
    .process-step-icon {
        font-size: 40px;
        /* Large icon size */
        margin-bottom: 10px;
    }

    /* Style for the text below the icon */
    .process-step span {
        font-size: 0.875rem;
        /* Smaller text size */
        margin-top: 8px;
    }


    /* Cơ bản cho trang */
    body {
        background-color: #f7fafc;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Tiêu đề chính */
    h1 {
        color: #333;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    /* Các bước sửa chữa */
    h2 {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    /* Tạo kiểu cho danh sách các bước */
    ol {
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }

    li {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1rem;
    }

    /* Bảng giá sửa chữa */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 1rem;
        text-align: left;
        border: 1px solid #ddd;
        font-size: 1.1rem;
    }

    th {
        background-color: #f1f1f1;
        font-weight: bold;
        color: #333;
    }

    td {
        background-color: #fafafa;
    }

    /* Nút bấm "Xem báo giá" */
    button {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        color: #007bff;
        background-color: transparent;
        border: 2px solid #007bff;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: #007bff;
        color: white;
    }

    /* Modal styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 10000;
    }

    .modal-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .modal-content h3 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .modal-content p {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .modal-content button {
        background-color: #e53e3e;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
    }

    .modal-content button:hover {
        background-color: #c53030;
    }

    /* Đảm bảo modal không bị lỗi hiển thị trên các màn hình nhỏ */
    @media (max-width: 640px) {
        .modal-content {
            width: 90%;
            padding: 1.5rem;
        }
    }
</style>