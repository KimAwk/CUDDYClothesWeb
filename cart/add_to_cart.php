<?php
session_start();
include 'db.php';

$product_id = $_GET['product_id'];
$quantity = $_GET['quantity'] ?? 1;
$user_id = $_SESSION['user_id'];

// Check if the product is already in the cart
$sql = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If it exists, update the quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;
    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
} else {
    // Otherwise, insert it into the cart
    $sql = "INSERT INTO cart (user_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)";
    $price = 1000; // Replace with actual product price from your database
    $total_price = $price * $quantity;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiidd", $user_id, $product_id, $quantity, $price, $total_price);
}

$stmt->execute();
header("Location: shop.php");
exit;

?>

