<?php
session_start();
include("db.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get the order ID from the URL
if (!isset($_GET['order_id'])) {
    echo "<h2>Invalid order ID.</h2>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Query to get order details with user and product information
$sql = "
    SELECT 
        o.order_id, o.username, o.address1, o.phone, o.description, o.total_price, o.order_date, o.status,
        p.name, p.price, p.image, p.description AS product_desc
    FROM 
        orders o
    JOIN 
        products p ON p.id = o.order_id  -- Adjust this condition based on your database schema
    WHERE 
        o.order_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if order details are found
if ($result->num_rows == 0) {
    echo "<h2>No details found for this order.</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F8E1E8;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #F06292;
        }

        .details, .products {
            margin-bottom: 20px;
        }

        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-item img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #F06292;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #EC407A;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Details</h2>
    
    <?php 
    // Display order details
    if ($row = $result->fetch_assoc()) {
        echo "<div class='details'>
                <p><strong>Username:</strong> {$row['username']}</p>
                <p><strong>Address:</strong> {$row['address1']}</p>
                <p><strong>Phone:</strong> {$row['phone']}</p>
                <p><strong>Description:</strong> {$row['description']}</p>
                <p><strong>Order Date:</strong> " . date("F j, Y", strtotime($row['order_date'])) . "</p>
                <p><strong>Total Price:</strong> " . number_format($row['total_price'], 0, ',', '.') . " VND</p>
                <p><strong>Status:</strong> " . ucfirst($row['status']) . "</p>
              </div>";

        // Display product information
        echo "<div class='products'>";
        do {
            echo "<div class='product-item'>
                    <img src='../img/products/{$row['image']}' alt='{$row['name']}'>
                    <div>
                        <p><strong>Product Name:</strong> {$row['name']}</p>
                        <p><strong>Price:</strong> " . number_format($row['price'], 0, ',', '.') . " VND</p>
                        <p><strong>Description:</strong> {$row['product_desc']}</p>
                    </div>
                  </div>";
        } while ($row = $result->fetch_assoc());
        echo "</div>";
    }
    ?>
    
    <a href="orders.php" class="btn-back">Back to Orders</a>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
