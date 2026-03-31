<?php 
include('config/dbcnn.php');
include('thanh/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách tài khoản</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Quản lý tài khoản</li>
    </ol>

    <!-- Hiển thị thông báo thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Hiển thị thông báo lỗi -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách các tài khoản
                        <a href="add-account.php" class="btn btn-primary float-end">Thêm tài khoản</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = "SELECT * FROM users";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['role']; ?></td>
                                        <td><a href="edit-admin.php?id=<?= $row['id']; ?>" class="btn btn-success">Edit</a></td>
                                        <td><a href="delete-admin.php?id=<?= $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>Không có tài khoản nào được tìm thấy</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('thanh/footer.php'); ?>
<?php include('thanh/script.php'); ?>
