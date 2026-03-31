<?php
session_start();
include("config/dbcnn.php");

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<h2 style='font-family: Arial, sans-serif; color: #333;'>Vui lòng đăng nhập để cập nhật trạng thái đơn hàng.</h2>";
    exit;
}

// Kiểm tra nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = htmlspecialchars(trim($_POST['status']));

    // Cập nhật trạng thái đơn hàng
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "<h2 style='font-family: Arial, sans-serif; color: green;'>Trạng thái đơn hàng đã được cập nhật.</h2>";
        header("Location: orders.php");
        exit;
    } else {
        echo "<h2 style='font-family: Arial, sans-serif; color: red;'>Đã có lỗi xảy ra khi cập nhật trạng thái.</h2>";
    }

    $stmt->close();
}
$conn->close();
?>
