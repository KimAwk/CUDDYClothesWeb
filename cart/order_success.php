<?php
session_start();
include("db.php");

// Kiểm tra nếu `order_id` tồn tại trong URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Kiểm tra nếu `order_id` là số hợp lệ
    if (!is_numeric($order_id)) {
        echo "<h2>Đơn hàng không hợp lệ.</h2>";
        exit;
    }

    // Lấy thông tin đơn hàng từ bảng `orders`
    $sql = "SELECT o.order_id, o.user_id, o.username, o.address1, o.phone, o.description, o.total_price, o.status, o.order_date, o.payment_method
            FROM orders o
            WHERE o.order_id = ?";
    $stmt = $conn->prepare($sql);

    // Kiểm tra lỗi chuẩn bị câu truy vấn
    if ($stmt === false) {
        echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_result = $stmt->get_result();

    if ($order_result->num_rows > 0) {
        $order = $order_result->fetch_assoc();

        echo '
        <style>
            body {
                font-family: "Roboto", Arial, sans-serif;
                background-color: #f9f9f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .order-container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                max-width: 600px;
                width: 90%;
                text-align: center;
            }
            .order-container h2 {
                color: #28a745;
                font-size: 24px;
                margin-bottom: 10px;
            }
            .order-container h3 {
                color: #333;
                margin-bottom: 20px;
            }
            .order-container p {
                color: #555;
                font-size: 16px;
                margin: 10px 0;
            }
            .order-container p strong {
                color: #333;
            }
            .order-container .total-price {
                font-size: 22px;
                color: #ff5722;
                font-weight: bold;
                margin: 20px 0;
            }
            .order-container .home-button,
            .order-container .payment-button {
                display: inline-block;
                margin: 10px 5px;
                padding: 12px 20px;
                font-size: 16px;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }
            .order-container .home-button {
                background-color: #007bff;
            }
            .order-container .home-button:hover {
                background-color: #0056b3;
            }
            .order-container .payment-button {
                background-color: #dc3545;
            }
            .order-container .payment-button:hover {
                background-color: #b02a37;
            }
        </style>
        ';
        echo "<div class='order-container'>";
        echo "<h2>Đặt hàng thành công! Cảm ơn bạn đã mua sắm.</h2>";
        echo "<h3>Thông tin đơn hàng #$order_id</h3>";
        echo "<p><strong>Tên người nhận:</strong> {$order['username']}</p>";
        echo "<p><strong>Địa chỉ:</strong> {$order['address1']}</p>";
        echo "<p><strong>Số điện thoại:</strong> {$order['phone']}</p>";
        echo "<p><strong>Phương thức thanh toán:</strong> {$order['payment_method']}</p>";
        echo "<p><strong>Mô tả:</strong> {$order['description']}</p>";
        echo "<p><strong>Ngày đặt hàng:</strong> " . date("d-m-Y H:i:s", strtotime($order['order_date'])) . "</p>";
        echo "<p><strong>Trạng thái:</strong> {$order['status']}</p>";

        // Hiển thị tổng giá trị đơn hàng
        echo "<h3>Tổng cộng: " . number_format($order['total_price']) . " đ</h3>";
        echo "<a href='../home.php' class='home-button'>Về trang chủ</a>";
        // Form thanh toán
        echo '
        <form method="POST" action="xulythanhtoanmomo.php" style="display:inline;">
            <input type="hidden" name="order_id" value="' . $order['order_id'] . '">
            <button type="submit" class="payment-button">Thanh Toán MOMO QRcode</button>
        </form>
        <form method="POST" action="xulythanhtoanmomo_atm.php" style="display:inline;">
            <input type="hidden" name="order_id" value="' . $order['order_id'] . '">
            <button type="submit" class="payment-button">Thanh Toán MOMO ATM</button>
        </form>';

        echo "</div>";
    } else {
        echo "<h2>Không tìm thấy hóa đơn.</h2>";
    }
} else {
    echo "<h2>Không có mã đơn hàng.</h2>";
}
?>
