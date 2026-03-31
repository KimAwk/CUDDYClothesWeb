<?php
require_once '../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('520085235215-d7jp9r9h6podspmn9podprrl81anmdd8.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/clothesweb/auth/callback.php'); // Chỉnh sửa URL của bạn
$client->addScope('email');

$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit;
?>

?>
