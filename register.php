<?php
include("./includes/header.php");
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Xử lý hiển thị mật khẩu
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const eyeIcon = btn.querySelector('.fa-eye');
                const eyeSlashIcon = btn.querySelector('.fa-eye-slash');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeSlashIcon.style.display = 'inline';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'inline';
                    eyeSlashIcon.style.display = 'none';
                }
            });
        });

        // Ẩn icon fa-eye-slash ban đầu
        document.querySelectorAll('.toggle-password').forEach(btn => {
            const eyeSlashIcon = btn.querySelector('.fa-eye-slash');
            eyeSlashIcon.style.display = 'none';
        });
    }); 
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Validate form đăng ký
        const form = document.getElementById('registerForm');
        const userNameField = document.getElementById('userName');
        const userEmailField = document.getElementById('userEmail');
        const userPhoneField = document.getElementById('userPhone');
        const userPasswordField = document.getElementById('userPassword');
        const userConfirmPasswordField = document.getElementById('userConfirmPassword');

        const userNameError = document.getElementById('userNameError');
        const userEmailError = document.getElementById('userEmailError');
        const userPhoneError = document.getElementById('userPhoneError');
        const userPasswordError = document.getElementById('userPasswordError');
        const userConfirmPasswordError = document.getElementById('userConfirmPasswordError');

        form.addEventListener('submit', function (e) {
            let isValid = true;

            // Reset error messages
            userNameError.textContent = '';
            userEmailError.textContent = '';
            userPhoneError.textContent = '';
            userPasswordError.textContent = '';
            userConfirmPasswordError.textContent = '';

            // Validate Họ tên
            if (userNameField.value.trim() === '') {
                userNameError.textContent = 'Vui lòng nhập họ tên.';
                isValid = false;
            }

            // Validate Email
            const email = userEmailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                userEmailError.textContent = 'Vui lòng nhập email.';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                userEmailError.textContent = 'Email không đúng định dạng.';
                isValid = false;
            }

            // Validate Số điện thoại
            const phoneRegex = /^0\d{9}$/;  // Số điện thoại bắt đầu bằng 0 và có đúng 10 chữ số

            if (userPhoneField.value.trim() === '') {
                userPhoneError.textContent = 'Vui lòng nhập số điện thoại.';
                isValid = false;
            } else if (!phoneRegex.test(userPhoneField.value.trim())) {
                userPhoneError.textContent = 'Số điện thoại phải gồm 10 chữ số (không chứ ký tự chữ) và bắt đầu bằng số 0.';
                isValid = false;
            }

            // Validate Mật khẩu
            const password = userPasswordField.value.trim();
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

            if (password === '') {
                userPasswordError.textContent = 'Vui lòng nhập mật khẩu.';
                isValid = false;
            } else if (password.length < 6) {
                userPasswordError.textContent = 'Mật khẩu phải có ít nhất 6 ký tự.';
                isValid = false;
            } else if (!passwordRegex.test(password)) {
                userPasswordError.textContent = 'Mật khẩu phải có ít nhất một chữ cái hoa, một chữ cái thường, một số và một ký tự đặc biệt.';
                isValid = false;
            }


            // Validate Xác nhận mật khẩu
            const confirmPassword = userConfirmPasswordField.value.trim();
            if (confirmPassword === '') {
                userConfirmPasswordError.textContent = 'Vui lòng xác nhận mật khẩu.';
                isValid = false;
            } else if (confirmPassword !== password) {
                userConfirmPasswordError.textContent = 'Mật khẩu và xác nhận mật khẩu không khớp.';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Ngừng gửi form nếu có lỗi
            }
        });
    });
</script>

<style>
    .error-text {
        color: red;
        font-size: 0.875rem;
        margin-top: 4px;
    }
</style>

<link rel="stylesheet" href="./assets/css/index.css">

<div class="registration-page">
    <div class="registration-container">
        <div class="illustration">
            <img src="./images/illustration/signup.png" alt="Registration illustration" />
        </div>
        <div class="registration-form">
            <h1>Đăng ký</h1>
            <form action="./functions/authcode.php" method="POST" id="registerForm">
                <div class="mb-3">
                    <b><label class="form-label">Họ tên</label></b>
                    <input type="text" name="userName" id="userName" class="form-control"
                        placeholder="Nhập họ tên của bạn">
                    <small id="userNameError" class="error-text"></small>
                </div>
                <div class="mb-3">
                    <b><label class="form-label">Email</label></b>
                    <input type="email" name="userEmail" id="userEmail" class="form-control"
                        placeholder="Nhập Email của bạn">
                    <small id="userEmailError" class="error-text"></small>
                </div>
                <div class="mb-3">
                    <b><label class="form-label">Số điện thoại</label></b>
                    <input type="text" name="userPhone" id="userPhone" class="form-control"
                        placeholder="Nhập số điện thoại của bạn">
                    <small id="userPhoneError" class="error-text"></small>
                </div>
                <div class="mb-3">
                    <b><label class="form-label">Mật khẩu</label></b>
                    <div class="input-group">
                        <input type="password" name="userPassword" id="userPassword" class="form-control"
                            placeholder="Nhập mật khẩu">
                        <button type="button" class="btn btn-outline-secondary toggle-password"
                            data-target="userPassword">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    <small id="userPasswordError" class="error-text"></small>
                </div>
                <div class="mb-3">
                    <b><label class="form-label">Xác nhận mật khẩu</label></b>
                    <div class="input-group">
                        <input type="password" name="userConfirmPassword" id="userConfirmPassword" class="form-control"
                            placeholder="Xác nhận mật khẩu">
                        <button type="button" class="btn btn-outline-secondary toggle-password"
                            data-target="userConfirmPassword">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    <small id="userConfirmPasswordError" class="error-text"></small>
                </div>

                <button type="submit" name="register_btn" class="register_btn btn btn-primary">Đăng Ký</button>
            </form>
            <p class="login-link mt-3">
                Bạn Đã Có Tài Khoản?
                <a href="./login.php">Đăng Nhập Ngay</a>
            </p>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>