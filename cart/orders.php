<?php
session_start();
include("db.php"); 

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn lấy các đơn hàng của người dùng từ cơ sở dữ liệu
$sql = "SELECT order_id, user_id, username, address1, phone, description, total_price, status, order_date FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra có đơn hàng nào không
if ($result->num_rows == 0) {
    echo "<h2>Chưa có đơn hàng nào được đặt.</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F8E1E8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #F06292;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #F06292;
        }

        table th {
            background-color: #F06292;
            color: white;
        }

        .status {
            font-weight: bold;
        }

        .status.pending {
            color: #FF9800;
        }

        .status.completed {
            color: #4CAF50;
        }

        .status.cancelled {
            color: #F44336;
        }

        .btn {
            padding: 8px 16px;
            background-color: #F06292;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #EC407A;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #F06292; 
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #EC407A; 
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Danh sách đơn hàng của bạn</h2>

    <table>
        <thead>
            <tr>
                <th>ID Đơn Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>#<?php echo $row['order_id']; ?></td> 
                    <td><?php echo date("F j, Y", strtotime($row['order_date'])); ?></td> 
                    <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> VND</td>
                    <td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>" class="btn">Xem Chi Tiết</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="../profile.php" class="back-btn">Quay lại Trang Cá Nhân</a>
</div>

</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
