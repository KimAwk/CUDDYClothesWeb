<?php
session_start();
include("config/dbcnn.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<h2>Vui lòng đăng nhập để xem đơn hàng.</h2>";
    exit;
}

// Truy vấn để lấy tất cả đơn hàng từ cơ sở dữ liệu
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Thêm CSS nội tuyến
echo "<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        form {
            display: flex;
            align-items: center;
        }
        select {
            margin-right: 10px;
            padding: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #007B9A;
        }
      </style>";

echo "<h2>Danh sách tất cả đơn hàng</h2>";

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Description</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Update Status</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['order_id'] . "</td>
                <td>" . $row['username'] . "</td>
                <td>" . $row['address1'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['description'] . "</td>
                <td>" . number_format($row['total_price'], 2) . "</td>
                <td>" . $row['status'] . "</td>
                <td>" . $row['order_date'] . "</td>
                <td>
                    <form method='POST' action='update_status.php'>
                        <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                        <select name='status'>
                            <option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                            <option value='done' " . ($row['status'] == 'done' ? 'selected' : '') . ">Done</option>
                        </select>
                        <button type='submit'>Update</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Không có đơn hàng nào.</h2>";
}

// Thêm nút quay về trang home.php
echo "<a href='donhang.php' class='back-button'>Quay về trang chủ</a>";

$conn->close();
?>
