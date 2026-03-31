<?php
session_start();

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Xóa thông báo sau khi đã hiển thị
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert" style="border-radius: 0; padding: 10px; background-color: #f8d7da;">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Xóa thông báo lỗi sau khi đã hiển thị
}
?>
