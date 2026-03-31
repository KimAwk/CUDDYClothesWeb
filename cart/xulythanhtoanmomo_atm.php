<?php
header('Content-type: text/html; charset=utf-8');

// Hàm thực hiện cURL
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// Địa chỉ endpoint của MoMo
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

// Cấu hình tài khoản MoMo
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua ATM MoMo";

// Lấy dữ liệu POST từ biểu mẫu
if (!isset($_POST['order_id'])) {
    echo "Lỗi: Không tìm thấy mã đơn hàng.";
    exit;
}

$order_id = $_POST['order_id'];

if (!is_numeric($order_id)) {
    echo "Lỗi: Mã đơn hàng không hợp lệ.";
    exit;
}

// Truy vấn cơ sở dữ liệu để lấy thông tin đơn hàng (giả sử bạn có kết nối `$conn`)
include("db.php");
$sql = "SELECT total_price FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Không tìm thấy đơn hàng.";
    exit;
}

$order = $result->fetch_assoc();
$amount = (int)$order['total_price']; // Tổng tiền thanh toán

// Các tham số bắt buộc
$orderId = time() . ""; // Sử dụng timestamp làm mã đơn hàng
$redirectUrl = "http://localhost:80/clothesweb/cart/process_momo_pay.php";
$ipnUrl = "http://localhost:80/clothesweb/cart/process_momo_pay.php";
$extraData = "";
$requestId = time() . "";
$requestType = "payWithATM"; // Loại thanh toán qua ATM
$uniqueOrderId = $_POST['order_id'] . "_" . time(); // Thêm timestamp để đảm bảo duy nhất


// Tạo chữ ký HMAC SHA256
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $uniqueOrderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

// Chuẩn bị dữ liệu JSON gửi đến API
$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $uniqueOrderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

// Gửi yêu cầu POST đến API MoMo
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

// Kiểm tra phản hồi từ MoMo
if (isset($jsonResult['payUrl'])) {
    // Chuyển hướng người dùng đến trang thanh toán của MoMo
    header('Location: ' . $jsonResult['payUrl']);
} else {
    // Hiển thị lỗi nếu không có URL thanh toán
    echo "Lỗi: Không tìm thấy payUrl trong kết quả trả về từ MoMo. Dữ liệu trả về là:";
    echo "<pre>";
    print_r($jsonResult);
    echo "</pre>";
}
?>
