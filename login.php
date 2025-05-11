<?php
include("./includes/header.php");
$rememberedAccounts = isset($_COOKIE['rememberedAccounts']) ? json_decode($_COOKIE['rememberedAccounts'], true) : [];
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailField = document.getElementById('userEmail');
        const passwordField = document.getElementById('userPassword');
        const rememberedAccounts = <?php echo json_encode($rememberedAccounts); ?>;

        emailField.addEventListener('input', function () {
            const email = emailField.value;
            if (rememberedAccounts[email]) {
                passwordField.value = rememberedAccounts[email];
            } else {
                passwordField.value = '';
            }
        });

        if (rememberedAccounts[emailField.value]) {
            passwordField.value = rememberedAccounts[emailField.value];
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailField = document.getElementById('userEmail');
        const passwordField = document.getElementById('userPassword');
        const form = document.getElementById('loginForm');

        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        const rememberedAccounts = <?php echo json_encode($rememberedAccounts); ?>;

        emailField.addEventListener('input', function () {
            const email = emailField.value;
            if (rememberedAccounts[email]) {
                passwordField.value = rememberedAccounts[email];
            } else {
                passwordField.value = '';
            }
        });

        if (rememberedAccounts[emailField.value]) {
            passwordField.value = rememberedAccounts[emailField.value];
        }

        form.addEventListener('submit', function (e) {
            let isValid = true;
            const email = emailField.value.trim();
            const password = passwordField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Reset error messages
            emailError.textContent = '';
            passwordError.textContent = '';

            // Validate email
            if (email === '') {
                emailError.textContent = 'Vui lòng nhập email.';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Email không đúng định dạng.';
                isValid = false;
            }

            // Validate password
            if (password === '') {
                passwordError.textContent = 'Vui lòng nhập mật khẩu.';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Ngăn submit nếu có lỗi
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
<style>
    .error-text {
        color: red;
        font-size: 0.875rem;
        margin-top: 4px;
        display: block;
    }
</style>


<link rel="stylesheet" href="./assets/css/index.css">
<div class="login-page">
    <div class="login-container">
        <div class="illustration">
            <img src="./images/illustration/login.png" alt="Login illustration" />
        </div>
        <div class="login-form">
            <h1>Đăng nhập</h1>
            <form action="./functions/authcode.php" method="POST" id="loginForm">
                <div class="mb-3">
                    <b><label for="email" class="form-label">Địa chỉ Email</label></b>
                    <input type="email" name="userEmail" class="form-control" id="userEmail" placeholder="Nhập Email"
                        value="<?php echo isset($_COOKIE['lastEmail']) ? $_COOKIE['lastEmail'] : ''; ?>">
                    <small id="emailError" class="error-text" style="color: red; font-size: 0.875rem;"></small>
                </div>

                <div class="mb-3">
                    <b><label for="password" class="form-label">Mật khẩu</label></b>
                    <div class="input-group">
                        <input type="password" name="userPassword" class="form-control" id="userPassword"
                            placeholder="Nhập mật khẩu">
                        <button type="button" class="btn btn-outline-secondary toggle-password"
                            data-target="userPassword">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                    <small id="passwordError" class="error-text"></small>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember_me" value="1">
                        <span>Nhớ mật khẩu</span>
                    </label>
                    <a href="forgot_password.php" class="forgot-password">Quên mật khẩu?</a>
                </div>
                <button type="submit" name="login_btn" class="login_btn btn btn-primary">Đăng nhập</button>
            </form>

            <p class="register-link">
                Bạn Chưa Có Tài Khoản? <a href="./register.php">Tạo tài khoản ngay</a>
            </p>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>