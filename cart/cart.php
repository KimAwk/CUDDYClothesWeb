<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-U  A-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Web</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <section id="header">
        <a href="#"><img src="../img/logo.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="../home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="../blog.php">Blog</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <?php
                // Khởi động session để truy cập thông tin người dùng (chỉ khi chưa được khởi động)
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    echo '<li><a href="products/product_list.php">Manage</a></li>';
                }
                ?>
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                ?>

                <!-- Phần hiển thị thông tin người dùng -->
                <div class="user-greeting">
                    <?php
                    if (isset($_SESSION['username'])) {
                        $username = htmlspecialchars($_SESSION['username']); // Xử lý tên người dùng để tránh XSS
                        echo "
        <div class='user-dropdown'>
            <button onclick='toggleUserDropdown()' class='greeting-btn'>
                Xin chào, <strong>$username</strong>
                <img src='../img/user.png' alt='User' style='width: 20px; margin-left: 10px;'>
            </button>
            <div id='userDropdownMenu' class='user-dropdown-menu'>
                <a href='../profile.php'>Thông tin cá nhân</a>
                <a href='../auth/logout.php'>Đăng xuất</a>
            </div>
        </div>
        ";
                    } else {
                        echo "<a href='../auth/login.php'><i class='fas fa-user'></i></a>";
                    }
                    ?>
                </div>

                <!-- CSS cho phần greeting -->
                <style>
                    .user-greeting {
                        font-size: 16px;
                        color: #333;
                        display: inline-block;
                    }

                    .user-dropdown {
                        position: relative;
                        display: inline-block;
                    }

                    .greeting-btn {
                        background-color: #FFB6C1;
                        /* Màu hồng pastel */
                        color: white;
                        padding: 10px 20px;
                        font-size: 16px;
                        border: none;
                        border-radius: 30px;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        transition: background-color 0.3s ease, transform 0.3s ease;
                    }

                    .greeting-btn:hover {
                        background-color: #FF69B4;
                        /* Màu hồng đậm */
                        transform: scale(1.05);
                    }

                    .greeting-btn img {
                        border-radius: 50%;
                        /* Ảnh dạng tròn */
                    }

                    .user-dropdown-menu {
                        display: none;
                        position: absolute;
                        background-color: #fff;
                        min-width: 160px;
                        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                        z-index: 1;
                        border-radius: 8px;
                        margin-top: 10px;
                        padding: 10px 0;
                    }

                    .user-dropdown-menu a {
                        color: #333;
                        padding: 12px 20px;
                        text-decoration: none;
                        display: block;
                        font-size: 14px;
                        transition: background-color 0.3s ease;
                    }

                    .user-dropdown-menu a:hover {
                        background-color: #f1f1f1;
                    }
                </style>

                <!-- JavaScript để bật/tắt dropdown -->
                <script>
                    function toggleUserDropdown() {
                        var dropdownMenu = document.getElementById('userDropdownMenu');
                        dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
                    }

                    // Đóng dropdown nếu người dùng nhấp bên ngoài
                    window.onclick = function (event) {
                        var dropdownMenu = document.getElementById('userDropdownMenu');
                        var dropdownButton = document.querySelector('.greeting-btn');
                        if (!dropdownButton.contains(event.target)) {
                            dropdownMenu.style.display = 'none';
                        }
                    }
                </script>
                <li>
                    <a href="cart.php">
                        <div class="icon-container">
                            <i class="far fa-shopping-bag"></i>
                            <span class="cart-quantity">
                                <?php echo getCartQuantity(); ?> <!-- Display the total quantity -->
                            </span>
                        </div>
                    </a>
                </li> <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
    </section>

    <?php
    function getCartQuantity()
    {
        $total_quantity = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total_quantity += $item['quantity'];
            }
        }
        return $total_quantity;
    }
    // Khởi động session để truy cập giỏ hàng (chỉ khi chưa được khởi động)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if 'cart' is not set, then initialize it as an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    include 'db.php';
    $total = 0;
    // Kiểm tra nếu giỏ hàng không có sản phẩm
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $product) {
            // Your existing code for displaying cart items
        }
    } else {
        echo "<h1>Giỏ hàng của bạn đang trống.</h1>";
    }
    ?>


    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $product_id => $product):
                    $subtotal = $product['price'] * $product['quantity']; // Tính subtotal cho từng sản phẩm
                    $total += $subtotal; // Cộng dồn tổng tiền
                    ?>
                    <tr>
                        <td><a href="remove_cart.php?product_id=<?php echo $product_id; ?>"><i
                                    class="far fa-times-circle"></i></a></td>
                        <td><img src="../img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>"
                                alt=""></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo number_format($product['price']); ?> đ</td>
                        <td>
                            <form action="update_cart.php" method="POST">
                                <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($subtotal); ?> đ</td> <!-- Hiển thị subtotal của sản phẩm -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <?php ?>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply coupon</h3>
            <div>
                <input type="text" placeholder="Enter your coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Cart total</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td><?php echo number_format($total); ?> đ</td> <!-- Tính tổng tiền giỏ hàng -->
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo number_format($total); ?> đ</strong></td> <!-- Tổng tiền -->
                </tr>
            </table>
            <!-- Nút Checkout để thanh toán -->
            <a href="checkout.php" class="normal">Đặt hàng</a>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="../img/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong> 234 Nguyen Van Dau, Ward 11, Binh Thanh District</p>
            <p><strong>Phone: </strong>0779678910</p>
            <p><strong>Hours: </strong> 9:00 - 22:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <a href="https://www.facebook.com/dinhhuy.truong.3910/"><i class="fab fa-facebook-f"></i></a>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="../img/pay/app.jpg" alt="">
                <img src="../img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways </p>
            <img src="../img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© Copyright Huy's Team. </p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>
