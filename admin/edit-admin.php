<?php 
include('config/dbcnn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id='$id' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_array($query_run);
    } else {
        echo "<script>alert('Không tìm thấy tài khoản');</script>";
        header("Location: permissions.php");
        exit(0);
    }
}

if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update_query = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id='$id'";
    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        echo "<script>alert('Cập nhật tài khoản thành công');</script>";
        header("Location: permissions.php");
        exit(0);
    } else {
        echo "<script>alert('Cập nhật tài khoản thất bại');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa tài khoản</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Chỉnh sửa tài khoản</h4>
            </div>
            <div class="card-body">
                <form action="edit-admin.php?id=<?= $user['id']; ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <div class="mb-3">
                        <label for="username">Tên người dùng</label>
                        <input type="text" name="username" value="<?= $user['username']; ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?= $user['email']; ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="role">Chức vụ</label>
                        <select name="role" class="form-control">
                            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?= ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="update_user" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
