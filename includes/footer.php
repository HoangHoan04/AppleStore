<div class="service-features">
    <div class="feature">
        <i class='bx bx-check-circle'></i>
        <div class="feature-text">
            <p>Mẫu mã đa dạng,</p>
            <p>chính hãng</p>
        </div>
    </div>
    <div class="feature">
        <i class='bx bxs-truck'></i>
        <div class="feature-text">
            <p>Giao hàng toàn quốc</p>
        </div>
    </div>
    <div class="feature">
        <i class='bx bx-shield'></i>
        <div class="feature-text">
            <p>Bảo hành có cam kết</p>
            <p>tới 12 tháng</p>
        </div>
    </div>
    <div class="feature">
        <i class='bx bx-sync'></i>
        <div class="feature-text">
            <p>Có thể đổi trả tại</p>
            <p>Thegioididong và DienmayXANH</p>
        </div>
    </div>
</div>

<footer>
    <div class="footer-wrapper">
        <div class="footer-content">
            <div class="footer-section contact">
                <div class="footer-logo">
                    <img src="./images/logo.png" alt="Apple">
                    <img src="./images/pngwing.com.png" alt="Premium Reseller">
                </div>
                <div class="contact-info">
                    <h3>Tổng đài</h3>
                    <p>Mua hàng: <a href="tel:0123.123.123">0123.123.123</a> (8:00 - 21:30)</p>
                    <p>Khiếu nại: <a href="tel:1900.1009.37">1900.1009.37</a> (8:00 - 21:30)</p>
                    <div class="social-links">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-youtube'></i></a>
                        <a href="#"><i class='bx bxl-skype'></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-section info">
                <h3>Hệ thống cửa hàng</h3>
                <ul>
                    <li><a href="#">Xem 86 cửa hàng</a></li>
                    <li><a href="#">Nội quy cửa hàng</a></li>
                    <li><a href="#">Chất lượng phục vụ</a></li>
                    <li><a href="#">Chính sách bảo hành & đổi trả</a></li>
                </ul>
            </div>

            <div class="footer-section info">
                <h3>Hỗ trợ khách hàng</h3>
                <ul>
                    <li><a href="#">Điều kiện giao dịch chung</a></li>
                    <li><a href="#">Hướng dẫn mua hàng online</a></li>
                    <li><a href="#">Chính sách giao hàng</a></li>
                    <li><a href="#">Hướng dẫn thanh toán</a></li>
                </ul>
            </div>

            <div class="footer-section info">
                <h3>Về thương hiệu AppleStore</h3>
                <ul>
                    <li><a href="#" class="highlight">Tích điểm Quà tặng VIP</a></li>
                    <li><a href="#">Giới thiệu AppleStore</a></li>
                    <li><a href="#">Bán hàng doanh nghiệp</a></li>
                    <li><a href="#">Chính sách xử lý dữ liệu cá nhân</a></li>
                    <li><a href="#">Xem bản mobile</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Trung tâm bảo hành TopCare</h3>
                <ul>
                    <li><a href="#">Giới thiệu TopCare</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025. Công ty cổ phần AppleStore. GPDKKD: 12343532545 do sở KH & ĐT TP.HCM cấp ngày 02/01/2025</p>
            <p>Địa chỉ:273 An Đ. Vương, Phường 2, Quận 5, Hồ Chí Minh. Điện thoại:0123.123.123. Địa chỉ liên hệ
                và
                gửi chứng từ: 105 Bà Huyện Thanh Quan, Phường 6, Quận 3, Hồ Chí Minh. Chịu trách nhiệm nội
                dung:
                Hoàng Đình Hoàn & Nguyễn Đình Thông. Email: appleStore@congnghethongtin.com</p>
        </div>
    </div>
</footer>
<!-- app js -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    <?php if (isset($_SESSION['message'])) {
        ?>
        alertify.set('notifier', 'position', 'top-right');
        alertify.success('<?= $_SESSION['message'] ?>');
        <?php
        unset($_SESSION['message']);
    }
    ?>
</script>