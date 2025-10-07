<?php
// Include the connection file
include 'Connection.php';

$message = "";
$message_type = ""; // To distinguish between success and error messages

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture the form data
    $email = $_POST['email'];
    $password = $_POST['your_pass'];

    // Validate form data
    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
        $message_type = "error";
    } else {
        // Check if the user exists in the database
        $sql = "SELECT * FROM logintbl WHERE email='$email' AND password='$password' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found, login successful
            $message = "Login successful!";
            $message_type = "success";
            $redirect = true; // Set flag for redirecting to dashboard/home
        } else {
            // User not found or incorrect password
            $message = "Invalid username or password.";
            $message_type = "error";
        }
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="regstyle.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Login form</title>
</head>
<body> 
    <div class="main">
        <!-- Sign In Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="Photos/sign up/signin.jpg" alt="sing up image"></figure>
                        <div>Create an account, <a href="signup.php" class="signup-image-link"><b>click here</b></a></div>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form method="POST" class="register-form" id="login-form" action="">
                        <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS for Toastr Notifications and Redirect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            <?php if (!empty($message)) { ?>
                toastr.<?php echo $message_type; ?>("<?php echo $message; ?>");
                
                // If login is successful, redirect after 2 seconds
                <?php if (isset($redirect) && $redirect === true) { ?>
                    setTimeout(function() {
                        window.location.href = 'Home Page.html';  // Redirect to dashboard or home page
                    }, 1000);  // 1 seconds delay
                <?php } ?>
            <?php } ?>
        });
    </script>

    
</body>
</html>