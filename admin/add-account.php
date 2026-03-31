<?php
ob_start(); // Bắt đầu đệm đầu ra

include('config/dbcnn.php');
include('thanh/header.php');  

// Xử lý khi form được submit
if (isset($_POST['add_account'])) {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Kiểm tra xem username có tồn tại trong cơ sở dữ liệu không
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu username đã tồn tại, thông báo lỗi
        echo "<script>alert('Username đã tồn tại, vui lòng chọn username khác.');</script>";
    } else {
        // Nếu username chưa tồn tại, thực hiện thêm tài khoản mới
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, email, role, password) VALUES ('$username', '$email', '$role', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            // Chuyển hướng tới trang danh sách tài khoản sau khi thêm thành công
            header('Location: permissions.php');
            exit(); // Dừng script sau khi chuyển hướng
        } else {
            echo "<script>alert('Lỗi khi thêm tài khoản.');</script>";
        }
    }
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Tài Khoản</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Quản lý tài khoản</li>
    </ol>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm tài khoản mới</h4>
                </div>
                <div class="card-body">
                    <form action="add-account.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="add_account" class="btn btn-primary">Thêm Tài Khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('thanh/footer.php'); ?>
<?php include('thanh/script.php'); ?>

<?php
ob_end_flush(); // Kết thúc đệm đầu ra và xuất toàn bộ dữ liệu
?>
