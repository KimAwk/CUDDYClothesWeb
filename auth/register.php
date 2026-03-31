<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    // Kiểm tra xem email đã tồn tại chưa
    $sql_check = "SELECT id FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Email đã tồn tại!";
    } else {
        // Chèn thông tin người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // Chuyển hướng đến trang đăng nhập
            header("Location: login.php");
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5; /* Màu nền sáng */
            font-family: 'Roboto', sans-serif;
            color: #202124; /* Màu chữ tối */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .register-form h2 {
            text-align: center;
            color: #1a73e8; /* Màu xanh giống Google */
            margin-bottom: 20px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #1a73e8;
        }
        .btn-primary {
            background-color: #1a73e8; /* Màu chính Google */
            border-color: #1a73e8;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #1669c1;
            border-color: #1669c1;
        }
        .form-check-label {
            color: #202124;
        }
        .form-check {
            margin-top: 15px;
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
        .text-center a {
            color: #1a73e8;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-form">
        <h2>Đăng ký tài khoản</h2>

        <!-- Nếu có thông báo lỗi hoặc thành công -->
        <div id="alert-container">
            <!-- Lỗi và thành công sẽ được hiển thị tại đây -->
        </div>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên người dùng" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Xác nhận mật khẩu" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms">
                <label class="form-check-label" for="terms">Tôi đồng ý với điều khoản sử dụng</label>
            </div>
            <div class="form-action">
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Đã có tài khoản? <a href="login.php" class="text-decoration-none">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 My Website</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>