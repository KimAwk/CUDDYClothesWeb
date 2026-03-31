<?php
// Bao gồm tệp kết nối cơ sở dữ liệu
include('db.php');

// Kiểm tra các tham số cần thiết từ MoMo
if (isset($_GET['partnerCode'])) {
    $partnerCode = $_GET['partnerCode'];
    $orderId = $_GET['orderId'];
    $amount = $_GET['amount'];
    $orderInfo = $_GET['orderInfo'];
    $transId = $_GET['transId'];
    $payType = $_GET['payType'];

    // Kiểm tra trạng thái trả về từ MoMo (resultCode, message)
    if ($_GET['resultCode'] == '0' && $_GET['message'] == 'Successful.') {
        // Chuẩn bị câu lệnh SQL để lưu vào cơ sở dữ liệu
        $insert_momo = "INSERT INTO bank_momo (partner_Code, order_Id, amount, order_Info, order_Type, trans_Id, pay_Type) 
                        VALUES ('$partnerCode', '$orderId', '$amount', '$orderInfo', 'momo_wallet', '$transId', '$payType')";

        // Thực thi câu lệnh SQL
        if ($conn->query($insert_momo)) {
            echo "Giao dịch thành công";
        } else {
            echo "Giao dịch thất bại: " . $conn->error;
        }
    } else {
        echo "Giao dịch không thành công. Lỗi: " . $_GET['message'];
    }
} else {
    echo "Thông tin không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>