<?php
include('config/dbcnn.php');

// Get the order ID from the URL parameter
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if ($order_id) {
    // Fetch the order details for editing
    $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "<p>Order not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid order ID.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated order data from the form
    $username = $_POST['username'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];
    $payment_method = $_POST['payment_method'];

    // Update the order in the database
    $update_sql = "UPDATE orders SET 
                        username = '$username', 
                        address1 = '$address', 
                        phone = '$phone', 
                        description = '$description', 
                        total_price = '$total_price', 
                        status = '$status', 
                        payment_method = '$payment_method' 
                    WHERE order_id = '$order_id'";

    if ($conn->query($update_sql) === TRUE) {
        // Redirect to donhang.php after successful update
        echo "<script>alert('Order updated successfully!'); window.location.href = 'donhang.php';</script>";
        exit;  // Ensure no further code is executed
    } else {
        echo "<p>Error updating order: " . $conn->error . "</p>";
    }
}

// Close the database connection
$conn->close();
?>

<!-- Inline CSS for form styling -->
<style>
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"], input[type="number"], select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus, input[type="number"]:focus, select:focus {
        border-color: #007bff;
        outline: none;
    }

    .btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-primary {
        width: 100%;
    }
</style>

<div class="container">
    <h2>Edit Order</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value="<?php echo $order['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" value="<?php echo $order['address1']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value="<?php echo $order['phone']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" name="description" value="<?php echo $order['description']; ?>" required>
        </div>
        <div class="form-group">
            <label for="total_price">Total Price:</label>
            <input type="number" class="form-control" name="total_price" value="<?php echo $order['total_price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" name="status">
                <option value="pending" <?php echo ($order['status'] == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="done" <?php echo ($order['status'] == 'done' ? 'selected' : ''); ?>>Done</option>
            </select>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select id="payment-method" name="payment_method" class="form-select" required>
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="Bank Transfer">Chuyển khoản ngân hàng</option>
                <option value="MoMo">Thanh toán bằng QR Code (MoMo)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Order</button>
    </form>
</div>
