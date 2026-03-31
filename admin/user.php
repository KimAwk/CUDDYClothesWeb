<?php
session_start();
include('config/dbcnn.php');

// Kiểm tra nếu người dùng là admin trước khi hiển thị danh sách
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='alert alert-danger'>Bạn không có quyền truy cập trang này.</div>";
    exit;
}

// Lấy danh sách các tài khoản có vai trò 'user'
$sql = "SELECT id, username, email, role FROM users WHERE role = 'user'";
$result = $conn->query($sql);
?>

<?php include('thanh/header.php'); ?> <!-- Include header -->

<div class="container mt-5">
    <h2>Danh sách tài khoản vai trò User</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['role']); ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Không có tài khoản nào được tìm thấy.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('thanh/footer.php'); ?>
<?php include('thanh/script.php'); ?>

<?php
$conn->close();
?>
