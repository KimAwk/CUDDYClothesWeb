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
        <a href="#"><img src="img/logo.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="home.php">Home</a></li>
                <li><a href="cart/shop.php">Shop</a></li>
                <li><a  href="blog.php">Blog</a></li>
                <li><a class="active"href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <!-- Add this HTML code where you want the username to be displayed -->

                <?php
// Start the session to access session variables
session_start();
?>

<!-- Add this HTML code where you want the username to be displayed -->
<div class="user-greeting">
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "
        <div class='user-dropdown'>
            <button onclick='toggleUserDropdown()' class='greeting-btn'>
                Xin chào, <strong>$username</strong>
                <img src='img/user.png' alt='User' style='width: 20px; margin-left: 10px;'>
            </button>
            <div id='userDropdownMenu' class='user-dropdown-menu'>
                <a href='profile.php'>Thông tin cá nhân</a>
                <a href='auth/logout.php'>Đăng xuất</a>
            </div>
        </div>
        ";
    } else {
        echo "<a href='auth/login.php'><i class='fas fa-user'></i></a>";
    }
    ?>
</div>

<!-- Styling for the greeting -->
<style>
    .user-greeting {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
        display: inline-block;
    }

    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .greeting-btn {
        background-color: #FFB6C1; /* Pastel pink */
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
        background-color: #FF69B4; /* Hot pink */
        transform: scale(1.05);
    }

    .greeting-btn img {
        border-radius: 50%; /* Circular icon */
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

<!-- JavaScript for toggling the dropdown -->
<script>
    function toggleUserDropdown() {
        var dropdownMenu = document.getElementById('userDropdownMenu');
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        var dropdownMenu = document.getElementById('userDropdownMenu');
        var dropdownButton = document.querySelector('.greeting-btn');
        if (!dropdownButton.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    }
</script>

                <li><a href="cart/cart.php"><i class="far fa-shopping-bag"></i></a></li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
    </section>
    
    <section id="page-header" class="about-header">
        <h2>#knowus</h2>
        <p>Lorem ipsum dolor sit amet, consectetur</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="img/about/a6.jpg" alt="">
        <div>
            <h2>Who We Are?</h2>
            <p>Về CUDDY TEE: <br>

                You will never be younger than you are at this very moment “Enjoy Your Youth!” <br>
                
                Không chỉ là thời trang, CUDDY TEE còn là “phòng thí nghiệm” của tuổi trẻ - nơi nghiên cứu và cho ra đời năng lượng mang tên “Youth”. Chúng mình luôn muốn tạo nên những trải nghiệm vui vẻ, năng động và trẻ trung.
                Lấy cảm hứng từ giới trẻ, sáng tạo liên tục, bắt kịp xu hướng và phát triển đa dạng các dòng sản phẩm là cách mà chúng mình hoạt động để tạo nên phong cách sống hằng ngày của bạn. Mục tiêu của TEELAB là cung cấp các sản phẩm thời trang chất lượng cao với giá thành hợp lý.
                Chẳng còn thời gian để loay hoay nữa đâu youngers ơi! Hãy nhanh chân bắt lấy những những khoảnh khắc tuyệt vời của tuổi trẻ. CUDDY TEE đã sẵn sàng trải nghiệm cùng bạn! <br>
                
                “Enjoy Your Youth”, now! <br>
                
                Hướng dẫn sử dụng sản phẩm CUDDY TEE: <br>
                - Ngâm áo vào NƯỚC LẠNH có pha giấm hoặc phèn chua từ trong 2 tiếng đồng hồ <br>
                - Giặt ở nhiệt độ bình thường, với đồ có màu tương tự. <br>
                - Không dùng hóa chất tẩy. <br>
                - Hạn chế sử dụng máy sấy và ủi (nếu có) thì ở nhiệt độ thích hợp. <br>
                
                Chính sách bảo hành: <br>
                - Miễn phí đổi hàng cho khách mua ởCUDDY TEE trong trường hợp bị lỗi từ nhà sản xuất, giao nhầm hàng, bị hư hỏng trong quá trình vận chuyển hàng. <br>
                - Sản phẩm đổi trong thời gian 3 ngày kể từ ngày nhận hàng <br>
                - Sản phẩm còn mới nguyên tem, tags và mang theo hoá đơn mua hàng, sản phẩm chưa giặt và không dơ bẩn, hư hỏng bởi những tác nhân bên ngoài cửa hàng sau khi mua hàng.</p> <br>
            <abbr title="">Cảm ơn quý khách đã tin tưởng và lựa chọn CUDDY TEE</abbr>
            <br> <br>
            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width=""100%>
                🔥 Khuyến mãi đặc biệt: Giảm giá đến 50% cho tất cả các sản phẩm! Mua ngay để không bỏ lỡ! 🔥
            </marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Download Our <a href="#">App</a></h1>
        <div class="video">
            <video autoplay muted loop src="img/about/1.mp4"></video>
        </div>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f3.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f4.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f5.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="">
            <h6>Free Shipping</h6>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our lastest  shop and <span>special offers.</span></p>
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