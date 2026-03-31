<?php
session_start();
include("db.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $total_price = 0;

    // Tính tổng giá trị đơn hàng từ giỏ hàng
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $total_price += $product['price'] * $product['quantity'];
    }

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Thêm đơn hàng vào bảng `orders`
        $sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id; // Lấy ID của đơn hàng vừa tạo

        // Cam kết giao dịch
        $conn->commit();

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);

        echo "Đặt hàng thành công! Cảm ơn bạn đã mua sắm.";
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        echo "Đã có lỗi xảy ra. Vui lòng thử lại!";
    }

} else {
    echo "Vui lòng đăng nhập để đặt hàng.";
}

?>
