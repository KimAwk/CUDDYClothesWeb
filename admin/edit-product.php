<?php
// Kết nối cơ sở dữ liệu
include('config/dbcnn.php');

// Kiểm tra nếu có tham số id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Lấy thông tin sản phẩm
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Sản phẩm không tồn tại.";
        exit(0);
    }
}

// Cập nhật sản phẩm
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (int)($_POST['price']);
    $image = $_POST['image']; // Dữ liệu ảnh cần được xử lý thêm nếu cần

    $update_query = "UPDATE products SET name = '$name', description = '$description', price = $price, image = '$image' WHERE id = $id";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: product.php?msg=Product updated successfully");
        exit(0);
    } else {
        echo "Lỗi cập nhật sản phẩm: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-control:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sửa Sản Phẩm</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
        </div>
        <button type="submit" name="update_product" class="btn">Cập nhật</button>
    </form>
</div>
</body>
</html>
