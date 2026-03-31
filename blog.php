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
                <li><a class="active" href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
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
    
    <section id="page-header" class="blog-header">
        <h2>#readmore</h2>
        <p>Read all case studies about our products!</p>
    </section>

    <section id="blog">
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b1.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>The cotton-Jersey can be trendy</h4>
                <p>Trong năm 2024, thời trang tiếp tục chứng kiến sự lên ngôi của những mẫu áo độc đáo, 
                    sáng tạo và đậm chất cá tính. Những thiết kế mang phong cách thời thượng từ áo sơ
                 mi oversized, áo crop top phong cách streetwear, đến áo...</p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>13/06</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b2.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>Elevate Your Casual Look: Styling Tips for Polo and T-Shirts</h4>
                <p>Nếu bạn yêu thích phong cách đơn giản và thoải mái, áo polo và áo thun 
                    là lựa chọn hoàn hảo. Với áo polo, hãy thử phối với quần jean hoặc kaki và 
                    thêm đôi giày sneaker để có vẻ ngoài vừa...</p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>11/05</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b3.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>T-Shirt Trends: The Ultimate Guide to Casual Comfort</h4>
                <p>Áo thun là món đồ không thể thiếu trong tủ đồ của mọi người, từ phong cách đường phố đến những dịp đi chơi thư giãn. Trong năm nay, xu hướng
                     áo thun tập trung vào những thiết kế đơn giản nhưng tinh tế với chất liệu cotton thoáng mát, form dáng oversized hoặc vừa vặn thoải mái... </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>05/04</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b4.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>Polo Shirts vs. T-Shirts: Which Suits Your Style?</h4>
                <p>Áo sơ mi polo và áo thun đều là hai món đồ linh hoạt và dễ phối đồ, nhưng mỗi loại có nét đặc trưng riêng biệt. Nếu bạn muốn một vẻ ngoài lịch sự, thoải mái 
                    và có thể diện trong nhiều tình huống, áo polo sẽ là lựa chọn hoàn hảo. 
                    Trong khi đó, áo thun lại mang đến cảm giác trẻ trung...</p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>23/03</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b5.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>Polos & Tees: Timeless Staples for Every Season</h4>
                <p>Áo polo và áo thun từ lâu đã trở thành những món đồ không bao giờ lỗi
                     mốt và thích hợp cho mọi mùa trong năm. Với chất liệu thoáng mát và thiết kế dễ mặc, áo thun phù hợp cho mùa hè năng động...</p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>08/02</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blog/b6.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4>T-Shirts Done Right: Finding Your Ideal Fit and Style</h4>
                <p>Một chiếc áo thun phù hợp không chỉ giúp bạn tự tin mà còn làm nổi bật cá tính của bạn. Để chọn được áo thun chuẩn đẹp, 
                    hãy lưu ý đến form dáng: áo oversized giúp bạn trông phóng khoáng, trong khi áo dáng slim-fit sẽ tôn dáng nếu bạn muốn
                     vẻ ngoài gọn gàng hơn...</p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>13/01</h1>
        </div>
        
    </section>

    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
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