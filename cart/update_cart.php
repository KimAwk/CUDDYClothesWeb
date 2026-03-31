<?php
session_start(); // Khởi động session để truy cập giỏ hàng

// Kiểm tra nếu có thông tin sản phẩm và số lượng
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Kiểm tra nếu sản phẩm có trong giỏ hàng
    if (isset($_SESSION['cart'][$product_id])) {
        // Cập nhật số lượng sản phẩm
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }

    // Chuyển hướng lại trang giỏ hàng
    header("Location: cart.php");
    exit;
}
?>
