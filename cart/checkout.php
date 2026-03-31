<?php 
session_start(); 
include 'db.php'; 

$total = array_reduce($_SESSION['cart'], function ($sum, $product) {
    return $sum + ($product['price'] * $product['quantity']);
}, 0); 

$totalQuantity = array_reduce($_SESSION['cart'], function ($sum, $product) {
    return $sum + $product['quantity'];
}, 0); 
?> 
<!DOCTYPE html> 
<html lang="vi"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Checkout</title> 

    <!--  Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> 
    <style>
        body {
            background-color: #f8f9fa; 
            font-family: 'Roboto', sans-serif;
        }
        .form-control, .form-select {
            background-color: #ffffff; 
            color: #333; 
            border: 1px solid #ced4da; 
            border-radius: 0.375rem;
        }
        .form-control:focus, .form-select:focus {
            background-color: #e9ecef; 
            border-color: #80bdff; 
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }
        .form-label {
            color: #495057; 
            font-weight: 500; 
        }
        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff; 
            padding: 10px 20px; 
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3; 
            border-color: #0056b3; 
        }
        .section-p1 {
            padding: 40px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            max-width: 700px;
            margin: 40px auto; 
        }
        .cart-summary {
            margin-bottom: 20px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            border-radius: 6px;
        }
        .cart-item p {
            margin: 5px 0;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .cart-summary p {
            font-size: 16px;
            font-weight: bold;
        }
        .cart-summary .total {
            font-size: 18px;
            font-weight: 600;
            color: #007bff;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head> 
<body> 
    <section id="checkout" class="section-p1"> 
        <h2>Nhập Thông Tin Đặt Hàng</h2> 
        <form action="process_checkout.php" method="POST"> 
            <div class="mb-3"> 
                <label for="name" class="form-label">Tên:</label> 
                <input type="text" id="name" name="name" class="form-control" required> 
            </div> 
            <div class="mb-3"> 
                <label for="address" class="form-label">Địa chỉ:</label> 
                <input type="text" id="address" name="address" class="form-control" required> 
            </div> 
            <div class="mb-3"> 
                <label for="phone" class="form-label">Số điện thoại:</label> 
                <input type="tel" id="phone" name="phone" class="form-control" required> 
            </div> 
            <div class="mb-3"> 
                <label for="description" class="form-label">Mô tả thêm (nếu có):</label> 
                <textarea id="description" name="description" class="form-control" rows="3"></textarea> 
            </div> 

            <!-- Cart summary -->
            <div class="cart-summary">
                <h3>Chi tiết giỏ hàng</h3>
                <?php foreach ($_SESSION['cart'] as $product): ?>
                    <div class="cart-item">
                        <img src="../img/products/<?php echo $product['image']; ?>" alt="Product Image">
                        <div>
                            <p><strong><?php echo $product['name']; ?></strong></p>
                            <p>Số lượng: <?php echo $product['quantity']; ?></p>
                            <p>Giá: <?php echo number_format($product['price']); ?> đ</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p><strong>Tổng số lượng sản phẩm:</strong> <?php echo $totalQuantity; ?></p>
            </div>

            <div class="mb-3 text-center"> 
                <p class="total">Tổng tiền: <?php echo number_format($total); ?> đ</p> 
            </div> 

            <div class="mb-3">
                <label for="payment-method" class="form-label">Phương thức thanh toán:</label>
                <select id="payment-method" name="payment_method" class="form-select" required>
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="Bank Transfer">Chuyển khoản ngân hàng</option>
                </select>
            </div>

            <div class="text-center"> 
                <button type="submit" class="btn btn-primary">Đặt hàng</button> 
            </div> 
        </form> 
    </section> 
    <script src="script.js"></script>
</body> 
</html>
