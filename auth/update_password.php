<?php
// Kết nối với cơ sở dữ liệu
include 'db.php';
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy mật khẩu cũ và mật khẩu mới từ form
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra nếu mật khẩu mới và xác nhận mật khẩu khớp
    if ($new_password !== $confirm_password) {
        $error = "Mật khẩu xác nhận không khớp.";
    } else {
        // Lấy mật khẩu hiện tại từ cơ sở dữ liệu
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($db_password);
        $stmt->fetch();

        // Kiểm tra mật khẩu cũ có đúng không
        if (!password_verify($current_password, $db_password)) {
            $error = "Mật khẩu hiện tại không đúng.";
        } else {
            // Mã hóa mật khẩu mới
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $update_sql = "UPDATE users SET password = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $hashed_new_password, $username);
            if ($update_stmt->execute()) {
                $success_message = "Mật khẩu đã được thay đổi thành công.";
            } else {
                $error = "Đã xảy ra lỗi, vui lòng thử lại sau.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #FF69B4;
            font-size: 1.8em;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-group label {
            font-weight: 600;
            color: #333; 
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 1em;
            margin-bottom: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #FF69B4;
            box-shadow: 0 0 8px rgba(255, 105, 180, 0.3);
        }

        .btn {
            background-color: #FF69B4;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1.1em;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            background-color: #FF4786;
        }

        .alert {
            border-radius: 8px;
            font-size: 1em;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #E9F7EF;
            color: #28A745;
        }

        .alert-danger {
            background-color: #F8D7DA;
            color: #DC3545;
        }

        a {
            text-align: center;
            display: block;
            margin-top: 20px;
            color: #FF69B4;
            text-decoration: none;
        }

        a:hover {
            color: #FF4786;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Change Your Password</h2>
        
        <?php if (isset($error)) { ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
        <?php } ?>
        
        <?php if (isset($success_message)) { ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Change Password</button>
        </form>
        
        <a href="../profile.php">Back to Profile</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>


