<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Web</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
    .icon-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.add-to-cart {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.add-to-cart button {
    padding: 10px 50px; /* Giảm độ rộng padding để gọn gàng hơn */
    background-color: #f0f0f0; /* Thay đổi màu nền */
    color: #333; /* Màu chữ tối hơn */
    border: 2px solid #333; /* Màu viền trùng với màu chữ */
    border-radius: 8px; /* Góc tròn lớn hơn */
    font-size: 14px; /* Phông chữ lớn hơn */
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s; /* Thêm hiệu ứng chuyển */
}

.add-to-cart button:hover {
    background-color: #333;
    color: #fff;
}

.add-to-cart i {
    margin-left: 5px; /* Giảm khoảng cách */
}

.view-details {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.view-details i {
    font-size: 1.3em; /* Nhỏ hơn để tinh tế hơn */
    margin-left: 8px;
    color: #333;
}

.view-details:hover i {
    color: #0056b3; /* Màu xanh đậm hơn */
}

.search-form {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    max-width: 350px; /* Giảm độ rộng */
    margin: 15px auto; /* Giảm khoảng cách */
    padding: 5px;
}

.search-form input[type="text"] {
    width: 100%;
    padding: 8px; /* Giảm padding */
    font-size: 14px; /* Giảm kích thước chữ */
    border: 2px solid #bbb;
    border-radius: 20px;
    outline: none;
    transition: border-color 0.3s;
}

.search-form input[type="text"]:focus {
    border-color: #0056b3;
}

.search-form button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background-color: #0056b3;
    color: #fff;
    border: none;
    padding: 8px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-form button:hover {
    background-color: #ff69b4;
}

.search-form button i {
    font-size: 16px;
}

@media (max-width: 600px) {
    .search-form {
        max-width: 100%;
        margin: 10px;
    }

    .search-form input[type="text"] {
        font-size: 12px;
    }

    .search-form button {
        padding: 6px;
    }
}
</style>
</head>

<body>

    <section id="header">
        <a href="#"><img src="../img/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="../home.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>

                <!-- Hiển thị "Manage" chỉ cho người dùng có vai trò 'admin' -->
                <?php
                session_start(); // Khởi động phiên làm việc
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                }
                ?>

                <li><a href="../blog.php">Blog</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <form action="../search.php" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." required>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form> 

                <li style="position: relative;">
                    <?php
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $userIcon = '../img/user.png'; // Replace with actual path to user icon image if needed
                    
                        // Display logged-in user's name and profile icon with dropdown
                        echo "
        <style>
            /* Styling for the user dropdown button */
            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropbtn {
                background-color: #FFB6C1; /* Pastel pink color */
                color: white;
                padding: 10px 20px;
                font-size: 16px;
                border: none;
                cursor: pointer;
                border-radius: 30px; /* Rounded corners for a more modern look */
                display: flex;
                align-items: center;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }

            /* Hover effect for the button */
            .dropbtn:hover {
                background-color: #FF69B4; /* Hot pink color on hover */
                transform: scale(1.05); /* Slightly enlarge the button on hover */
            }

            /* User icon style */
            .dropbtn img {
                border-radius: 50%; /* Make the user icon circular */
                margin-left: 10px;
            }

            /* Styling for the dropdown menu */
            .dropdown-content {
                display: none; /* Initially hidden */
                position: absolute;
                background-color: #fff;
                min-width: 160px;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 1;
                border-radius: 8px;
                margin-top: 10px;
                padding: 10px 0;
            }

            /* Style the items inside the dropdown */
            .dropdown-content a {
                color: #333;
                padding: 12px 20px;
                text-decoration: none;
                display: block;
                font-size: 14px;
                transition: background-color 0.3s ease;
            }

            /* Hover effect for dropdown items */
            .dropdown-content a:hover {
                background-color: #f1f1f1; /* Light grey background on hover */
                color: #333;
            }

            /* Show the dropdown when the button is clicked */
            .dropdown:hover .dropdown-content {
                display: block;
            }

            /* Close dropdown when clicking outside */
            body {
                margin: 0;
                font-family: 'Arial', sans-serif;
            }

            /* Additional space for body to ensure the dropdown is not affected */
            body, html {
                height: 100%;
                overflow-x: hidden;
            }
        </style>
        <div class='dropdown'>
            <button onclick='toggleDropdown()' class='dropbtn'>
                Xin chào, <span>$username</span> 
                <img src='$userIcon' alt='User' style='width: 20px; margin-left: 10px;'>
            </button>
            <div id='dropdownMenu' class='dropdown-content' style='display: none;'>
                <a href='../profile.php'>Thông tin cá nhân</a>
                <a href='../auth/logout.php'>Đăng xuất</a>
            </div>
        </div>
        ";
                    } else {
                        // If not logged in, show login link
                        echo "<a href='../auth/login.php'><i class='fas fa-user'></i></a>";
                    }
                    ?>
                </li>

                <script>
                    function toggleDropdown() {
                        var dropdownMenu = document.getElementById("dropdownMenu");
                        // Toggle visibility of the dropdown menu
                        if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
                            dropdownMenu.style.display = "block";
                        } else {
                            dropdownMenu.style.display = "none";
                        }
                    }

                    // Close dropdown if clicked outside of the dropdown area
                    window.onclick = function (event) {
                        var dropdownMenu = document.getElementById("dropdownMenu");
                        var dropdownButton = document.querySelector('.dropbtn');
                        if (!dropdownButton.contains(event.target)) {
                            dropdownMenu.style.display = "none";
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
                </li>

            </ul>
        </div>
    </section>

    <section id="page-header" style="background-image: url('../img/banner/b1.jpg');">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
    </section>

    <?php
    // Đã gọi session_start() rồi ở trên, không cần gọi lại ở đây
    include 'db.php'; // Kết nối cơ sở dữ liệu
    // Hàm tính tổng số lượng sản phẩm trong giỏ hàng
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

    // Lấy tất cả sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM products"; // Câu lệnh SQL lấy tất cả sản phẩm
    $result = $conn->query($sql); // Thực thi câu lệnh và lấy kết quả
    
    if (isset($_GET['add_to_cart'])) {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang login
            header("Location: ../auth/login.php");
            exit;
        }

        $product_id = $_GET['add_to_cart'];
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity; // Cập nhật số lượng sản phẩm
        } else {
            // Lấy thông tin sản phẩm từ database
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();

            // Thêm sản phẩm vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        }
    }
    ?>

<section id="product1" class="section-p1">
    <div class="pro-container">
        <?php
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        while ($product = $result->fetch_assoc()):
            ?>
            <div class="pro">
                <img src="../img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>"
                    alt="">
                <div class="des">
                    <h5><?php echo $product['name']; ?></h5> <!-- Tên sản phẩm -->
                    <div class="star">
                        <!-- Hiển thị sao -->
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <h4><?php echo number_format($product['price']); ?> đ</h4> <!-- Giá sản phẩm -->
                </div>
                <div class="icon-container">
                    <!-- Nút thêm vào giỏ hàng với sự kiện onclick -->
                    <a href="?add_to_cart=<?php echo $product['id']; ?>&quantity=1" 
                       class="add-to-cart" 
                       onclick="return confirmAddToCart('<?php echo $product['name']; ?>');">
                        <button>THÊM VÀO GIỎ</button>
                    </a>
                    <!-- Icon xem chi tiết -->
                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="view-details">
                        <i class="far fa-eye eye-icon"></i>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<script>
function confirmAddToCart(productName) {
    // Hiển thị hộp thoại xác nhận
    if (confirm("Bạn có muốn thêm '" + productName + "' vào giỏ hàng không?")) {
        alert("Đã thêm '" + productName + "' vào giỏ hàng thành công!");
        return true; // Cho phép chuyển hướng
    } else {
        return false; // Ngăn chặn chuyển hướng
    }
}
</script>


    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our lastest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
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
