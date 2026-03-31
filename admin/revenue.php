<?php
include('config/dbcnn.php'); 

// Truy vấn tổng doanh thu từ tất cả đơn hàng
$query_all_orders = "SELECT SUM(total_price) AS total_revenue FROM orders";
$result_all_orders = $conn->query($query_all_orders);
$total_revenue = 0;

if ($result_all_orders->num_rows > 0) {
    $row_all_orders = $result_all_orders->fetch_assoc();
    $total_revenue = $row_all_orders['total_revenue'];
}

// Truy vấn tổng doanh thu từ đơn hàng đã "done"
$query_done_orders = "SELECT SUM(total_price) AS done_revenue FROM orders WHERE status = 'done'";
$result_done_orders = $conn->query($query_done_orders);
$done_revenue = 0;

if ($result_done_orders->num_rows > 0) {
    $row_done_orders = $result_done_orders->fetch_assoc();
    $done_revenue = $row_done_orders['done_revenue'];
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doanh thu</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            text-align: center;
        }
        h1 {
            margin-bottom: 40px;
            color: #333;
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
        }
        .chart-wrapper {
            width: 48%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .chart-wrapper canvas {
            max-width: 100%;
            height: auto;
        }
        .btn-back {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Tổng hợp Doanh thu</h1>

    <!-- Container for both charts -->
    <div class="chart-container">
        <!-- All Orders Chart -->
        <div class="chart-wrapper">
            <h3>Tất cả Đơn hàng</h3>
            <canvas id="allOrdersChart"></canvas>
        </div>

        <!-- Done Orders Chart -->
        <div class="chart-wrapper">
            <h3>Đơn hàng đã Hoàn thành</h3>
            <canvas id="doneOrdersChart"></canvas>
        </div>
    </div>

    <!-- Back Button -->
    <a href="index.php" class="btn-back">Quay lại Trang Chủ</a>
</div>

<script>
    const totalRevenue = <?php echo $total_revenue ? $total_revenue : 0; ?>;
    const doneRevenue = <?php echo $done_revenue ? $done_revenue : 0; ?>;

    // All Orders Chart
    const ctxAllOrders = document.getElementById('allOrdersChart').getContext('2d');
    new Chart(ctxAllOrders, {
        type: 'bar',
        data: {
            labels: ['Tất cả Đơn hàng'],
            datasets: [{
                label: 'Tổng Doanh Thu (VND)',
                data: [totalRevenue],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Done Orders Chart
    const ctxDoneOrders = document.getElementById('doneOrdersChart').getContext('2d');
    new Chart(ctxDoneOrders, {
        type: 'bar',
        data: {
            labels: ['Đơn hàng Hoàn thành'],
            datasets: [{
                label: 'Tổng Doanh Thu (VND)',
                data: [doneRevenue],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
