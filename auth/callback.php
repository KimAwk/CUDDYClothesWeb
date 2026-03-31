<?php
require_once '../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('520085235215-d7jp9r9h6podspmn9podprrl81anmdd8.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/clothesweb/auth/callback.php');  // This must match the one registered in Google Developer Console
$client->addScope('email');
$client->addScope('profile');


if (isset($_GET['code'])) {
    // Nhận mã ủy quyền từ Google và lấy token truy cập
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Lấy thông tin người dùng từ Google
    $googleService = new Google_Service_Oauth2($client);
    $googleUser = $googleService->userinfo->get();

    $username = $googleUser->name;
    $email = $googleUser->email;

    include('db.php');

    // Kiểm tra xem email đã tồn tại trong bảng users_google chưa
    $sql_check = "SELECT id FROM users_google WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        // Chưa có người dùng, tiến hành đăng ký
        $sql = "INSERT INTO users_google (username, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);

        if ($stmt->execute()) {
            // Đăng ký thành công, chuyển hướng đến trang chủ
            header("Location: ../home.php");
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        // Người dùng đã tồn tại, chuyển hướng đến trang chủ
        header("Location: home.php");
        exit;
    }
} else {
    echo "Đăng nhập Google thất bại.";
}
?>
