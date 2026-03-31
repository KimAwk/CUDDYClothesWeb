<?php 
include('config/dbcnn.php');
include('thanh/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách đơn hàng</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Quản lý đơn hàng</li>
    </ol>

    <!-- Inline CSS for custom styling -->
    <style>
        .btn-warning {
            background-color: #f0ad4e;
            border-color: #eea236;
        }
        
        .btn-warning:hover {
            background-color: #ec971f;
            border-color: #d58512;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Styling for the update status select box */
        .form-control {
            width: 150px;
        }

        /* Styling the table to make it more readable */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            cursor: pointer;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        /* Center the Edit button column */
        .text-center {
            text-align: center;
        }
    </style>

    <!-- Orders Table -->
    <div class="mt-4">
        <?php
        // Query to fetch all orders
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Username</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Payment Method</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Output data for each order
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
                        <td>" . $row['payment_method'] . "</td>
                        <td class='text-center'>
                            <a href='edit_order.php?order_id=" . $row['order_id'] . "' class='btn btn-warning btn-sm'>
                                <i class='fas fa-edit'></i> Edit
                            </a>
                        </td>
                    </tr>";
            }

            echo '</tbody></table>';
        } else {
            echo "<p>Không có đơn hàng nào.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>

<?php include('thanh/footer.php'); ?>
<?php include('thanh/script.php'); ?>
