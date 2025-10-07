<?php
// Include the connection file
include 'Connection.php';
$message = "";
$message_type = ""; // To distinguish success and error messages
// Start by checking if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['re_pass'];

    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
        $message_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $message_type = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "error";
    } else {
        // No password hashing (storing plain text passwords)
        $plain_password = $password;
        // Check if email already exists
        $email_check_query = "SELECT * FROM logintbl WHERE email='$email' LIMIT 1";
        $result = $conn->query($email_check_query);
        if ($result->num_rows > 0) {
            $message = "Email already exists.";
            $message_type = "error";
        } else {
            // Insert user into the database without hashed password
            $sql = "INSERT INTO logintbl (name, email, password) VALUES ('$name', '$email', '$plain_password')";
            if ($conn->query($sql) === TRUE) {
                $message = "Registration successful!";
                $message_type = "success";
               //  redirect the user
               $redirect = true;
               //header('Location: login.php');
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
                $message_type = "error";
            }
        }
    }
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Now</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="regstyle.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
    <div class="main" id="main-form">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form" action="">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="Photos/sign up/signup.jpg" alt="sing up image"></figure>
                        <div>Your are already a member, <a href="signin.php" class="signup-image-link"><b>click here</b></a></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS for Toastr Notifications, Loading Spinner and Redirect -->
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if (!empty($message)) { ?>
                toastr.<?php echo $message_type; ?>("<?php echo $message; ?>");
                
                // Check if it's a success message to trigger the redirect
                <?php if (isset($redirect) && $redirect === true) { ?>
                    setTimeout(function() {
                        // Show loading spinner and hide the main form
                        $('#main-form').hide();
                        $('#loader').show();

                        // After 2 seconds, redirect to login.php
                        setTimeout(function() {
                            window.location.href = 'signin.php';
                        }, 2000);
                    }, 1000);  // Delay for 1 second after showing notification
                <?php } ?>
            <?php } ?>
        });
    </script>

</body>
</html>