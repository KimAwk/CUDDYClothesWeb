<?php 
include('config/dbcnn.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa tất cả các bản ghi liên quan trong bảng orders trước
    $delete_orders_query = "DELETE FROM orders WHERE user_id='$id'";
    $delete_orders_result = mysqli_query($conn, $delete_orders_query);

    // Kiểm tra nếu việc xóa đơn hàng thành công thì xóa tài khoản
    if($delete_orders_result) {
        $delete_user_query = "DELETE FROM users WHERE id='$id'";
        $delete_user_result = mysqli_query($conn, $delete_user_query);

        if($delete_user_result) {
            echo "<script>alert('Tài khoản đã được xóa thành công');</script>";
            header("Location: permissions.php");
            exit(0);
        } else {
            echo "<script>alert('Xóa tài khoản thất bại');</script>";
            header("Location: permissions.php");
            exit(0);
        }
    } else {
        echo "<script>alert('Không thể xóa các bản ghi liên quan trong bảng orders');</script>";
        header("Location: permissions.php");
        exit(0);
    }
}
?>
