<?php
session_start(); // Khởi động session để truy cập giỏ hàng

// Kiểm tra nếu có product_id trong URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Kiểm tra nếu sản phẩm có tồn tại trong giỏ hàng
    if (isset($_SESSION['cart'][$product_id])) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$product_id]);
    }

    // Chuyển hướng lại trang giỏ hàng
    header("Location: cart.php");
    exit;
}
?>
