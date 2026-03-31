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
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="contact.php">Contact</a></li>
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
        <h2>#Let's talk</h2>
        <p>LLEAVE A MESSAGE, we love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit one of our agency locations or contact us</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>contact@example.com</p>
                </li>
                <li>
                    <i class="fal fa-envelope"></i>
                    <p>contact@example.com</p>
                </li>
                <li>
                    <i class="fal fa-phone-alt"></i>
                    <p>contact@example.com</p>
                </li>
                <li>
                    <i class="fal fa-clock"></i>
                    <p>Thứ 2 đến Chủ nhật: 9:00 - 20:00</p>
                </li>
            </div>
        </div>
        
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.78786891905!2d106.6974508758803!3d10.827539589324383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528f4a62fce9b%3A0xc99902aa1e26ef02!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBWxINuIExhbmcgLSBDxqEgc-G7nyBjaMOtbmg!5e0!3m2!1svi!2s!4v1729922265665!5m2!1svi!2s" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <from action="">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" placeholder="Your name">
            <input type="text" placeholder="E-mail">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your massage"></textarea>
            <button class="normal">Submit</button>
        </from>

        <div class="people">
            <div>
                <img src="img/people/1.png" alt="">
                <p><span>Nguyễn Trần Tiến</span> Senior Marketing Mangager<br>
                Phone: 0123 456 789 <br> Email: contact@example.com</p>
            </div>
            <div>
                <img src="img/people/2.png" alt="">
                <p><span>Trương Đình Huy</span> Senior Marketing Mangager<br>
                Phone: 0123 456 789 <br> Email: contact@example.com</p>
            </div>
            <div>
                <img src="img/people/3.png" alt="">
                <p><span>Nguyễn Nam Khánh</span> Senior Marketing Mangager<br>
                Phone: 0123 456 789 <br> Email: contact@example.com</p>
            </div>
            <div>
                <img src="img/people/3.png" alt="">
                <p><span>Võ Kim Anh</span> Senior Marketing Mangager<br>
                Phone: 0123 456 789 <br> Email: contact@example.com</p>
            </div>
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