<?php
include("./includes/header.php");
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hiển thị/ẩn mật khẩu
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
        // Validate Mật khẩu và Xác nhận mật khẩu
        const form = document.getElementById('forgotPasswordForm');
        form.addEventListener('submit', function (e) {
            let isValid = true;

            const passwordField = document.getElementById('userPassword');
            const confirmPasswordField = document.getElementById('userConfirmPassword');
            const emailField = document.getElementById('userEmail');

            const passwordError = document.getElementById('userPasswordError');
            const confirmPasswordError = document.getElementById('userConfirmPasswordError');
            const emailError = document.getElementById('userEmailError');

            // Mã regex cho mật khẩu: ít nhất 1 chữ hoa, 1 chữ thường, 1 số, và 1 ký tự đặc biệt
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Reset lỗi trước khi validate
            emailError.textContent = '';
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';


            const email = emailField.value.trim();
            if (email === '') {
                emailError.textContent = 'Vui lòng nhập email.';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Email không đúng định dạng.';
                isValid = false;
            }

            // Validate Mật khẩu
            const password = passwordField.value.trim();
            if (password === '') {
                passwordError.textContent = 'Vui lòng nhập mật khẩu.';
                passwordError.style.display = 'block';
                isValid = false;
            } else if (!passwordRegex.test(password)) {
                passwordError.textContent = 'Mật khẩu phải có ít nhất một chữ cái hoa, một chữ cái thường, một số và một ký tự đặc biệt.';
                passwordError.style.display = 'block';
                isValid = false;
            } else {
                passwordError.style.display = 'none';
            }

            // Validate Xác nhận mật khẩu
            const confirmPassword = confirmPasswordField.value.trim();
            if (confirmPassword === '') {
                confirmPasswordError.textContent = 'Vui lòng xác nhận mật khẩu.';
                confirmPasswordError.style.display = 'block';
                isValid = false;
            } else if (confirmPassword !== password) {
                confirmPasswordError.textContent = 'Mật khẩu không khớp.';
                confirmPasswordError.style.display = 'block';
                isValid = false;
            } else {
                confirmPasswordError.style.display = 'none';
            }

            // Ngừng gửi form nếu có lỗi
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<style>
    .error-text {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>

<div class="forgotPassword-page">
    <div class="forgotPassword-container">
        <div class="illustration">
            <img src="./images/illustration/forgotpassword.png" alt="ForgotPassword illustration" />
        </div>
        <div class="forgotPassword-form">
            <h1>Khôi phục mật khẩu</h1>
            <form method="post" action="./functions/authcode.php" id="forgotPasswordForm">
                <div class="mb-3">
                    <b><label class="form-label" for="userEmail">Email bạn đã đăng ký với hệ thống</label></b>
                    <input type="text" name="userEmail" id="userEmail" class="form-control"
                        placeholder="Nhập số email bạn đã đăng ký trước đây">
                    <small id="userEmailError" class="error-text"></small>
                </div>
                <div class="mb-3">
                    <b><label class="form-label" for="userPassword">Mật khẩu mới</label></b>
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
                    <b><label class="form-label" for="userConfirmPassword">Xác nhận mật khẩu mới</label></b>
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

                <button class="forgotPassword_btn btn btn-primary" name="reset_password_btn" type="submit">Cập nhật mật
                    khẩu</button>
            </form>
            <p class="login-link">
                Trở về trang
                <a href="./login.php">Đăng Nhập</a>
            </p>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>