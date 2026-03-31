<?php
include("db.php");

// Kiểm tra thông tin truyền vào qua POST
if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
    echo "Lỗi: Mã đơn hàng không được để trống.";
    exit;
}

$order_id = $_POST['order_id'];
$amount = (int)$order['total_price'];

if (!is_numeric($order_id)) {
    echo "Lỗi: Mã đơn hàng không hợp lệ.";
    exit;
}

// Truy vấn lấy thông tin đơn hàng
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
    echo "Lỗi: Không tìm thấy đơn hàng với mã #" . htmlspecialchars($order_id);
    exit;
}

$order = $result->fetch_assoc();
$amount = (Int)$order['total_price']; // Tổng tiền thanh toán

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
// Cấu hình MoMo
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán đơn hàng #" . $order_id;
$redirectUrl = "http://localhost/clothesweb/cart/process_momo_pay.php";
$ipnUrl = "http://localhost/clothesweb/cart/process_momo_pay.php";
$requestType = "captureWallet";
$extraData = "";
$requestId = time() . "";
$uniqueOrderId = $_POST['order_id'] . "_" . time(); // Thêm timestamp để đảm bảo duy nhất


// Tạo chữ ký
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" 
    . $uniqueOrderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" 
    . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

// Dữ liệu gửi tới API MoMo
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

$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

// Kiểm tra phản hồi từ MoMo
if (isset($jsonResult['payUrl'])) {
    $payUrl = $jsonResult['payUrl'];

    // Tạo mã QR từ URL thanh toán
    // $qrCode = new QrCode($payUrl);
    // header('Content-Type: image/png');
    // echo $qrCode->writeString(); // Hiển thị mã QR dưới dạng PNG

    // Hoặc bạn có thể sử dụng mã QR đã có sẵn:
    echo '<img src="../img/qrmomo.jpg" alt="Mã QR thanh toán MoMo" />';
} else {
    echo "Lỗi: Không tạo được liên kết thanh toán.";
    echo "<pre>";
    echo "Kết quả trả về từ MoMo:\n";
    print_r($jsonResult); // In ra chi tiết kết quả trả về từ MoMo
    echo "</pre>";
}
?>

