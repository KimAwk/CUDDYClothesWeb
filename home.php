<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Web</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">

    <style>
/* Styling the search form container */
.search-form {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    max-width: 400px; /* Adjust width as needed */
    margin: 20px auto;
    padding: 5px;
}

/* Styling the input field */
.search-form input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 2px solid #ccc; /* Light border color */
    border-radius: 25px;
    outline: none;
    transition: border-color 0.3s ease;
}

/* Input field focus effect */
.search-form input[type="text"]:focus {
    border-color: #007bff; /* Blue border on focus */
}

/* Styling the search button */
.search-form button {
    position: absolute;
    right: 5px; /* Adjust button placement */
    top: 50%;
    transform: translateY(-50%);
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button hover effect */
.search-form button:hover {
    background-color: #FFC0CB; /* Darker blue on hover */
}

/* Styling the search icon inside the button */
.search-form button i {
    font-size: 18px; /* Icon size */
}

/* Mobile responsiveness */
@media (max-width: 600px) {
    .search-form {
        max-width: 100%;
        margin: 10px;
    }

    .search-form input[type="text"] {
        font-size: 14px;
    }

    .search-form button {
        padding: 8px;
    }
}
</style>
</head>
<script>
    // JavaScript function để hiển thị hoặc ẩn dropdown
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    }

    // Đóng dropdown khi người dùng click ra ngoài
    window.onclick = function (event) {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (!event.target.matches('.user-icon') && !event.target.matches('#dropdownMenu') && !event.target.matches('.user-icon img')) {
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    }
</script>

<body>

    <section id="header">
        <a href="#"><img src="img/logo.png" class="logo" alt="Logo"></a>

        <div>
    <ul id="navbar">
        <li><a class="active" href="home.php">Home</a></li>
        <li><a href="cart/shop.php">Shop</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." required>
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <?php
        session_start(); // Khởi động session để truy cập thông tin người dùng
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        }
        ?>

<li style="position: relative;">
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $userIcon = 'img/user.png';

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
                <a href='profile.php'>Thông tin cá nhân</a>
                <a href='auth/logout.php'>Đăng xuất</a>
            </div>
        </div>
        ";
    } else {
        // If not logged in, show login link
        echo "<a href='auth/login.php'><i class='fas fa-user'></i></a>";
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
    window.onclick = function(event) {
        var dropdownMenu = document.getElementById("dropdownMenu");
        var dropdownButton = document.querySelector('.dropbtn');
        if (!dropdownButton.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    }
</script>


<!-- Cart Link -->
                <li>
                    <a href="cart/cart.php">
                        <div class="icon-container">
                            <i class="far fa-shopping-bag"></i>
                            <span class="cart-quantity">
                                <?php echo getCartQuantity(); ?> <!-- Display the total quantity -->
                            </span>
                        </div>
                    </a>
                </li>


        
    </section>

    <section id="hero">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all products</h1>
        <p>Save more with coupons & up to 70% off!</p>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="">
            <h6 class="vne">Miễn phí ship</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="">
            <h6 class="vne">Mua sắm trực tuyến</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f3.png" alt="">
            <h6 class="vne">Đảm bảo hàng hóa</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f4.png" alt="">
            <h6 class="vne">Tiết kiệm tiền</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f5.png" alt="">
            <h6 class="vne">Hỗ trợ 24/7</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="">
            <h6 class="vne">Tiết kiệm thời gian</h6>
        </div>
    </section>

    <?php
    // Đã gọi session_start() rồi ở trên, không cần gọi lại ở đây
    include 'auth/db.php'; // Kết nối cơ sở dữ liệu
    
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
            $product_bsl = $stmt->get_result()->fetch_assoc();

            // Thêm sản phẩm vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'name' => $product_bsl['name'],
                'price' => $product_bsl['price'],
                'image' => $product_bsl['image'],
                'quantity' => $quantity
            ];
        }
    }
    ?>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <?php
            include("auth/db.php");

            $sql = "SELECT id, name, description, price, image, rating FROM products";
            $result = $conn->query($sql);

                while ($product_bsl = $result->fetch_assoc()) {
                    echo "<div class='pro'>";
                    echo "<img src='img/products/" . htmlspecialchars($product_bsl['image']) . "' alt='Clothing Image'>";
                    echo "<div class='des'>";
                    echo "<h5>" . htmlspecialchars($product_bsl["name"]) . "</h5>"; // Display clothing name
            
                    // Display rating with stars
                    echo "<div class='star'>";
                    for ($i = 0; $i < $product_bsl["rating"]; $i++) {
                        echo "<i class='fas fa-star'></i>";
                    }
                    echo "</div>";

                    echo "<h4>" . htmlspecialchars(number_format($product_bsl['price'], 0, '', ',')) . " VND</h4>"; // Display price
                    echo "</div>";
                    echo "<div class='icon-container'>";
                    echo "<a href='?add_to_cart=" . $product_bsl['id'] . "&quantity=1' class='add-to-cart'>
                        <button class='newbutton'>THÊM VÀO GIỎ</button>
                      </a>"; // Add to Cart button
                    echo "<a href='cart/product_detail.php?id=" . $product_bsl['id'] . "' class='view-details'>
                      <i class='far fa-eye eye-icon'></i> <!-- Icon for viewing details -->
                    </a>";

                    echo "</div>";
                    echo "</div>";
                    
                }
            $conn->close();
            ?>
        </div>
    </section>


    <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>70% off</span> - All t-Shirts & Accessories</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <?php
            include("auth/db.php");

            $sql = "SELECT id, name, description, price, image, rating FROM products";
            $result = $conn->query($sql);

                while ($product_bsl = $result->fetch_assoc()) {
                    echo "<div class='pro'>";
                    echo "<img src='img/products/" . htmlspecialchars($product_bsl['image']) . "' alt='Clothing Image'>";
                    echo "<div class='des'>";
                    echo "<h5>" . htmlspecialchars($product_bsl["name"]) . "</h5>"; // Display clothing name
            
                    // Display rating with stars
                    echo "<div class='star'>";
                    for ($i = 0; $i < $product_bsl["rating"]; $i++) {
                        echo "<i class='fas fa-star'></i>";
                    }
                    echo "</div>";

                    echo "<h4>" . htmlspecialchars(number_format($product_bsl['price'], 0, '', ',')) . " VND</h4>"; // Display price
                    echo "</div>";
                    echo "<div class='icon-container'>";
                    echo "<a href='?add_to_cart=" . $product_bsl['id'] . "&quantity=1' class='add-to-cart'>
                        <button class='newbutton'>THÊM VÀO GIỎ</button>
                      </a>"; // Add to Cart button
                    echo "<a href='cart/product_detail.php?id=" . $product_bsl['id'] . "' class='view-details'>
                      <i class='far fa-eye eye-icon'></i> <!-- Icon for viewing details -->
                    </a>";

                    echo "</div>";
                    echo "</div>";
                    
                }
            $conn->close();
            ?>
        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Crazy deals in my shop</h4>
            <h2>Buy 1 get 1 free!</h2>
            <span>Sales off in spring season</span>
            <button class="white">See More</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>New wears in my shop</h4>
            <h2>Sales off 60%</h2>
            <span>new shirt for spring season</span>
            <button class="white">See More Here</button>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>SEASON SALE</h2>
            <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>NEW FOOTWEAR COLLECTION</h2>
            <h3>Spring / Summer 2024</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>T-SHIRTS</h2>
            <h3>New Trendy Prints</h3>
        </div>
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
            <img class="logo" src="img/logo.png" alt="">
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
                <img src="img/pay/app.jpg" alt="">
                <img src="img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways </p>
            <img src="img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© Copyright Huy's Team. </p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>