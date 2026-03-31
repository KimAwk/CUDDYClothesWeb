<?php
// Kết nối với cơ sở dữ liệu
include 'auth/db.php';
session_start();

$username = $_SESSION['username'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT id, username, email, created_at FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $username, $email, $created_at);
$stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* General styles for the profile page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        /* Profile content */
        #profile {
            background-color: #ffffff;
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header h2 {
            color: #FFB6C1; /* Pastel pink */
            font-size: 2em;
        }

        .profile-header p {
            color: #333;
            font-size: 1em;
            margin: 5px 0;
        }

        .navbar-nav .nav-item {
            margin-right: 15px;
        }

        .navbar-nav .nav-item a {
            color: #FFB6C1;
        }

        .navbar-nav .nav-item a:hover {
            color: #FF69B4; /* Darker pastel pink */
        }

        .tab-content {
            margin-top: 20px;
        }

        .tab-pane {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Order table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #FFB6C1;
            color: white;
        }
        .btn {
            background-color: #FFB6C1;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-change-password:hover {
            background-color: #FF69B4;
        }

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">User Profile</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php" data-toggle="tab">Profile Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart/orders.php" data-toggle="tab">Orders</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Profile content -->
    <section id="profile">
        <div class="container">
            <div class="profile-header text-center">
                <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                <p>Email: <?php echo htmlspecialchars($email); ?></p>
                <p>Member Since: <?php echo date("F j, Y", strtotime($created_at)); ?></p>
            </div>

            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div class="tab-pane container active" id="profileInfo">
                    <h3>Profile Information</h3>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Member Since:</strong> <?php echo date("F j, Y", strtotime($created_at)); ?></p>
                    
                    <a href="home.php" class="btn">Về Trang Chủ</a>
                    <a href="auth/update_password.php" class="btn">Change Password</a>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane container fade" id="orders">
                    <h3>Your Orders</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date Ordered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order_stmt->fetch()) { ?>
                            <tr>
                                <td><?php echo $order_id; ?></td>
                                <td><?php echo number_format($total_price, 2); ?> VND</td>
                                <td><?php echo ucfirst($status); ?></td>
                                <td><?php echo date("F j, Y", strtotime($order_created_at)); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ($order_stmt->num_rows == 0) { ?>
                    <p>You have no orders placed yet.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Bootstrap JS (jQuery and Popper.js required for Bootstrap 4) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
