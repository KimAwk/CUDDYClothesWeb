<?php
include 'connect.php';

// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Xử lý ảnh
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image = $_FILES['image']['name'];
    $imageName = pathinfo($image, PATHINFO_FILENAME); // Lấy tên file gốc
    $imagePath = $imageName . ".jpg"; // Đặt đường dẫn đích với đuôi .jpg
    
    // Di chuyển file ảnh từ thư mục tạm thời đến thư mục đích
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        // Lưu đường dẫn ảnh mới vào cơ sở dữ liệu
    } else {
        echo "An error occurred while uploading the image.";
        exit;
    }
} else {
    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
    $imagePath = $_POST['existing_image']; // Đảm bảo ảnh cũ vẫn được giữ lại nếu không cập nhật ảnh
}

// Cập nhật sản phẩm với dữ liệu mới
$sql = "UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsi", $name, $description, $price, $imagePath, $id); // Gán các biến cho câu truy vấn

    if ($stmt->execute()) {
        echo "Product updated successfully!";
        header("Location: product_list.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Nếu không phải POST hoặc thiếu tham số 'id', lấy dữ liệu từ URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);

        // Kiểm tra nếu có kết quả
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Product not found!";
            exit;
        }
    } else {
        echo "Product ID not specified!";
        exit;
    }
}
?>

<form method="post" action="edit_product.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
    <input type="hidden" name="existing_image" value="<?php echo isset($row['image']) ? $row['image'] : ''; ?>">

    Name: <input type="text" name="name" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>"><br>
    Description: <textarea name="description"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea><br>
    Price: <input type="text" name="price" value="<?php echo isset($row['price']) ? $row['price'] : ''; ?>"><br>

    <!-- Hiển thị ảnh hiện tại -->
    <p>Current Image:</p>
    <img src="<?php echo isset($row['image']) && !empty($row['image']) ? $row['image'] : 'img/products/default-image.jpg'; ?>" alt="Product Image" width="100"/><br>

    <!-- Chọn ảnh mới -->
    Image: <input type="file" name="image"><br>

    <button type="submit">Update Product</button>
</form>
