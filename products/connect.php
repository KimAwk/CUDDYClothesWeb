<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "123456";
$dbName = "webclothes";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>