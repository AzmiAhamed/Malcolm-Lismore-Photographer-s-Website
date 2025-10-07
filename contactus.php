<?php
// Include the database connection file
include 'Connection.php'; // Adjust the path if necessary

$toastrType = '';
$toastrMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $message = mysqli_real_escape_string($conn, filter_var($_POST['message'], FILTER_SANITIZE_STRING));

    $errors = [];

    if (empty($name)) $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email address is required.";
    if (empty($message)) $errors[] = "Message is required.";

    if (empty($errors)) {
        $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $toastrType = 'success';
            $toastrMessage = 'Thank you for contacting us. We will get back to you shortly!';
        } else {
            $toastrType = 'error';
            $toastrMessage = 'Failed to submit. Please try again later.';
        }
    } else {
        $toastrType = 'error';
        $toastrMessage = implode('<br>', $errors);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- Remixicon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="Home Page.css" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>
<body>

<header class="header" id="home">
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <a href="#"><img src="Photos/logo-white.png" alt="logo" /></a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li class="nav__logo">
                <a href="#"><img src="Photos/logo-white.png" class="logo_size" alt="logo" /></a>
            </li>
            <li><a href="Home Page.html">HOME</a></li>
            <li><a href="View Blog.html">BLOG</a></li>
            <li><a href="contactus.php">CONTACT US</a></li>
            <button onclick="location.href='signin.php'" class="btn" id="loginbtn">LOGIN</button>
        </ul>
    </nav>
    <div>
        <h1 class="header_container">Contact Us</h1>
    </div>
</header>

<!-- Contact Form -->
<div>
    <form class="form" action="contactus.php" method="POST">
        <h2>CONTACT US</h2>
        <p type="Name:"><input type="text" name="name" placeholder="Write your name here.." required></p>
        <p type="Email:"><input type="email" name="email" placeholder="Let us know how to contact you back.." required></p>
        <p type="Message:"><input type="text" name="message" placeholder="What would you like to tell us.." required></p>
        <br>
        <button type="submit" class="contactbtn">Send Message</button>
        <div class="num">
            <span class="fa fa-phone"></span>07XXXXXXXX
            <span class="fa fa-envelope-o"></span> contactus@company.com
        </div>
    </form>
</div>

<!-- Footer -->
<footer id="contact">
    <div class="section__container footer__container">
        <div class="footer__col">
            <img src="Photos/logo-dark.jpg" class="logo_size" alt="logo" />
            <div class="footer__socials">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-instagram-line"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
                <a href="#"><i class="ri-youtube-fill"></i></a>
                <a href="#"><i class="ri-whatsapp-line"></i></a>
            </div>
        </div>
        <div class="footer__col">
            <ul class="footer__links">
                <li><a href="Home Page.php">HOME</a></li>
                <li><a href="View Blog.php">BLOG</a></li>
            </ul>
            <br>
            <p>Thank you for visiting Malcolm Lismore Photographer’s Website</p>
        </div>
        <div class="footer__col">
            <h4>STAY IN TOUCH</h4>
            <p>Keep up-to-date with all things Capturer! Join our community and
                never miss a moment! <br> More Details Contact us <br>
                +94 7XXXXXXXX    +94 7XXXXXXXX
            </p>
        </div>
    </div>
    <div class="footer__bar">
        © 2025 Malcolm Lismore Photographer’s Website. All rights reserved.
    </div>
</footer>

<!-- JS Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toastr Notification Script -->
<script>
    $(document).ready(function () {
        <?php if (!empty($toastrMessage)) { ?>
            toastr["<?= $toastrType ?>"]("<?= $toastrMessage ?>");
        <?php } ?>
    });
</script>

<script src="main.js"></script>

</body>
</html>
