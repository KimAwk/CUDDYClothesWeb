<?php
include 'connect.php';

// Prepare query to get all products from the database
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #4caf50;
            margin: 20px 0;
            font-size: 2.5rem;
        }

        .btn {
            display: inline-block;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th {
            padding: 12px;
            background-color: #4caf50;
            color: white;
            text-align: left;
        }

        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-edit, .btn-delete {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 0.9rem;
            }

            th, td {
                padding: 8px;
            }

            .btn {
                font-size: 1rem;
            }

            td img {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>

<h2>Danh sách Sản phẩm</h2>
<a href="../home.php" class="btn">Trang Chủ</a>
<a href="add_product.php" class="btn">Thêm Sản phẩm</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên Sản phẩm</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($product = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $product['id']; ?></td>
        <td>
            <?php 
                $image = $product['image'];
                // Kiểm tra và tạo đường dẫn cho ảnh
                $imagePath = !empty($image) ? 'img/products/' . (pathinfo($image, PATHINFO_EXTENSION) ? $image : $image . '.jpg') : 'img/products/default-image.jpg';
            ?>
            <img src="<?php echo $imagePath; ?>" alt="Product Image" width="100" height="100">
        </td>
        <td><?php echo $product['name']; ?></td>
        <td><?php echo $product['description']; ?></td>
        <td><?php echo $product['price']; ?> đ</td>
        <td>
            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn-edit">Sửa</a>
            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
        </td>
    </tr>
<?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
