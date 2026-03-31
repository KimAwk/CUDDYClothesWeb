<?php
session_start(); // Đảm bảo session được khởi động
include 'auth/db.php'; // Kết nối cơ sở dữ liệu

// Hàm lấy tổng số lượng sản phẩm trong giỏ hàng
function getCartQuantity() {
    $total_quantity = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_quantity += $item['quantity'];
        }
    }
    return $total_quantity;
}

// Kiểm tra nếu có yêu cầu thêm sản phẩm vào giỏ hàng
if (isset($_GET['add_to_cart'])) {
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!isset($_SESSION['username'])) {
        header("Location: ../auth/login.php"); // Chuyển hướng đến trang đăng nhập
        exit;
    }

    // Lấy ID sản phẩm và số lượng từ URL
    $product_id = intval($_GET['add_to_cart']); // Chuyển đổi thành số nguyên
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

    // Truy vấn lấy thông tin sản phẩm từ cơ sở dữ liệu
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($_SESSION['cart'][$product_id])) {
            // Tăng số lượng sản phẩm
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        }

        // Hiển thị thông báo thành công
        echo "<script>alert('Bạn đã thêm sản phẩm \"{$product['name']}\" vào giỏ hàng thành công!');</script>";
    } else {
        echo "<script>alert('Sản phẩm không tồn tại!');</script>";
    }

    // Quay lại trang trước
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// Kiểm tra tìm kiếm sản phẩm
if (isset($_GET['q'])) {
    $search = $_GET['q'];

    // Truy vấn tìm kiếm với LIKE (tìm sản phẩm theo tên hoặc mô tả)
    if (!empty($search)) {
        // Nếu từ khóa tìm kiếm có dấu cách (có thể là tìm kiếm chung), sử dụng LIKE để tìm tất cả sản phẩm có chứa từ khóa
        if (strpos($search, ' ') !== false) {
            // Tìm kiếm tất cả sản phẩm có chứa từ khóa
            $query = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
        } else {
            // Tìm kiếm chính xác cho từ khóa
            $query = "SELECT * FROM products WHERE name = ? OR description = ?";
        }

        // Thực hiện truy vấn
        $stmt = $conn->prepare($query);
        $searchTerm = '%' . $search . '%'; // Tạo điều kiện LIKE cho tìm kiếm chung
        $stmt->bind_param('ss', $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    // Truy vấn tất cả sản phẩm từ cơ sở dữ liệu để hiển thị khi không tìm kiếm
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <title>Kết quả tìm kiếm</title>
    <style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f4f8;
    color: #333;
}

.section-p1 {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    background-color: #f5f9ff;
    border-radius: 20px;
    padding: 30px;
    margin: 0 auto;
    max-width: 1200px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.pro-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjusts the number of columns dynamically */
    gap: 20px;
    width: 100%;
}

.pro {
    border-radius: 15px;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff, #e7eaf0);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
    padding: 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.pro:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 20px rgba(0, 0, 0, 0.15), 0 8px 10px rgba(0, 0, 0, 0.05);
}

.pro img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
    transition: transform 0.3s ease-in-out;
}

.pro img:hover {
    transform: scale(1.05);
}

.des {
    text-align: center;
}

.des h5 {
    font-size: 20px;
    font-weight: 600;
    color: #3b3f48;
    margin-bottom: 8px;
    line-height: 1.3;
}

.des .star {
    color: #ffc107;
    font-size: 16px;
    margin-bottom: 10px;
}

.des h4 {
    font-size: 22px;
    color: #2c3e50;
    font-weight: bold;
}

.icon-container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-top: 15px;
}

.add-to-cart {
    flex: 1;
}

.add-to-cart button {
    background: linear-gradient(145deg, #28a745, #218838);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: background 0.3s;
    width: 100%;
}

.add-to-cart button:hover {
    background: linear-gradient(145deg, #218838, #28a745);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.view-details {
    flex: 1;
}

.view-details i {
    font-size: 24px;
    color: #007bff;
    transition: color 0.3s;
    margin-left: 20px;
}

.view-details i:hover {
    color: #0056b3;
}

.back-home {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.back-home a {
    display: inline-block;
    background-color: #3b5998;
    color: #fff;
    padding: 10px 30px;
    text-decoration: none;
    border-radius: 15px;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s;
    text-align: center;
}

.back-home a:hover {
    background-color: #2c3e78;
}

@media (max-width: 768px) {
    .pro-container {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Adjusts columns to fit smaller screens */
    }
}

@media (max-width: 480px) {
    .pro-container {
        grid-template-columns: 1fr; /* Single column layout for mobile screens */
    }
}
    </style>
</head>
<body>
<section id="product1" class="section-p1">
    <div class="pro-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="pro">
                    <img src="img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>" alt="">
                    <div class="des">
                        <h5><?php echo $product['name']; ?></h5>
                        <div class="star">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <h4><?php echo number_format($product['price']); ?> đ</h4>
                    </div>
                    <div class="icon-container">
                        <a href="#" class="add-to-cart" onclick="confirmAddToCart(<?php echo $product['id']; ?>)">
                            <button>THÊM VÀO GIỎ</button>
                        </a>
                        <a href="cart/product_detail.php?id=<?php echo $product['id']; ?>" class="view-details">
                            <i class="far fa-eye eye-icon"></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php endif; ?>
    </div>
</section>

    <!-- Back to Home button -->
    <div class="back-home">
        <a href="home.php">Quay lại trang chủ</a>
    </div>

    <script>
        function confirmAddToCart(productId) {
            if (confirm("Bạn có muốn thêm vào giỏ hàng không?")) {
                window.location.href = "?add_to_cart=" + productId + "&quantity=1";
            }
        }
    </script>
</body>
</html>
