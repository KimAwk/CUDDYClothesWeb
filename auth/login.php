<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra email, mật khẩu và vai trò người dùng
    $sql = "SELECT id, username, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Chuyển hướng dựa trên vai trò của người dùng
        if ($role === 'admin') {
            header("Location: ../admin/index.php");
        } else if ($role === 'user') {
            header("Location: ../home.php");
        }
        exit;
    } else {
        echo "<div class='alert alert-danger'>Email hoặc mật khẩu không chính xác!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Roboto', sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 380px;
        }
        .login-form {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .login-form:hover {
            transform: translateY(-5px);
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #6200ea;
            font-weight: 500;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #6200ea;
            background-color: #f5f5f5;
        }
        .form-check-label {
            margin-left: 5px;
            color: #555;
        }
        .btn-primary {
            background-color: #6200ea;
            border-color: #6200ea;
            transition: background-color 0.3s ease-in-out;
            width: 100%;
            padding: 12px;
        }
        .btn-primary:hover {
            background-color: #3700b3;
            border-color: #3700b3;
        }
        .alert {
            border-radius: 8px;
            margin-top: 15px;
        }
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            color: #555;
        }
        .footer p {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h2>Đăng nhập</h2>
        
        <!-- Nếu có thông báo lỗi hoặc thành công -->
        <div id="alert-container">
            <!-- Lỗi và thành công sẽ được hiển thị tại đây -->
        </div>
        
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <div class="form-action mt-3">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Chưa có tài khoản? <a href="register.php" class="text-decoration-none text-primary">Đăng ký ngay</a></p>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 My Website</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>
