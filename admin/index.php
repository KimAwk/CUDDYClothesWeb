<?php 
session_start();
include('config/dbcnn.php');

// Kiểm tra nếu chưa đăng nhập, chuyển hướng về trang login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('thanh/header.php'); 
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Đây là trang chủ của Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Chào mừng đến với trang admin, bạn có thể quản lý hệ thống bao gồm các quyền như:
            <ul>
                <li>Chỉnh sửa danh mục sản phẩm</li>
                <li>Thêm, sửa, xóa các sản phẩm</li>
                <li>Quản lý các tài khoản</li>
                <li>Theo dõi tình trạng các đơn hàng</li>
            </ul>
        </li>
    </ol>
</div>

<?php 
include('thanh/footer.php');
include('thanh/script.php'); 
?>
