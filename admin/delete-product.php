<?php
// Kết nối cơ sở dữ liệu
include('config/dbcnn.php');

// Kiểm tra nếu có tham số id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $delete_query = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $delete_query)) {
        header("Location: product.php?msg=Product deleted successfully");
        exit;
    } else {
        echo "Lỗi xóa sản phẩm: " . mysqli_error($conn);
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}
?>
