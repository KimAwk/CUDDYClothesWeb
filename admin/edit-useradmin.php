<?php
session_start();
include('config/dbcnn.php');

// Kiểm tra nếu người dùng là admin trước khi truy cập trang này
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='alert alert-danger'>Bạn không có quyền truy cập trang này.</div>";
    exit;
}

// Kiểm tra nếu có ID từ query string và lấy thông tin admin
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = ? AND role = 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        echo "<script>alert('Không tìm thấy tài khoản admin');</script>";
        header("Location: account-admin.php");
        exit(0);
    }
}

// Xử lý cập nhật thông tin admin
if (isset($_POST['update_admin'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update_query = "UPDATE users SET username = ?, email = ? WHERE id = ? AND role = 'admin'";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin admin thành công');</script>";
        header("Location: account-admin.php");
        exit(0);
    } else {
        echo "<script>alert('Cập nhật thất bại');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Chỉnh sửa thông tin Admin</h2>
        <form action="edit-admin.php?id=<?= htmlspecialchars($admin['id']); ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id']); ?>">
            <div class="mb-3">
                <label for="username">Tên người dùng</label>
                <input type="text" name="username" value="<?= htmlspecialchars($admin['username']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($admin['email']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <button type="submit" name="update_admin" class="btn btn-primary">Cập nhật</button>
                <a href="admin.php" class="btn btn-secondary">Quay về</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
