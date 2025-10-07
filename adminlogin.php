<?php
// Include the connection file
include 'Connection.php';

$message = "";
$message_type = ""; // To distinguish between success and error messages
$redirect = false; // Initialize the redirect flag

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture the form data and sanitize it
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validate form data
    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
        $message_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $message_type = "error";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM adminlogin WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Check if the password matches (use password hashing in practice)
            if ($password === $row['password']) {
                $message = "Login successful!";
                $message_type = "success";
                $redirect = true; // Set flag for redirecting to dashboard/home
            } else {
                $message = "Invalid username or password.";
                $message_type = "error";
            }
        } else {
            // User not found
            $message = "Invalid username or password.";
            $message_type = "error";
        }

        // Close the statement
        $stmt->close();
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
    <link rel="stylesheet" href="adminlog.css">
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <title>Admin Login</title>
</head>
<body>
    <div class="form-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="form-container">
                        <div class="form-icon">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <!-- Ensure the form method is POST and fields have correct names -->
                        <form class="form-horizontal" method="POST" action="">
                            <h3 class="title">Admin Login</h3>
                            <div class="form-group position-relative mb-3">
                                <span class="input-icon"><i class="fa fa-envelope"></i></span>
                                <input class="form-control" type="email" name="email" placeholder="Enter the Email Address" required>
                            </div>
                            <div class="form-group position-relative mb-3">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                <input class="form-control" type="password" name="password" placeholder="Enter the Password" required>
                            </div>
                            <button class="btn-signin" type="submit">Login</button>
                            <div class="text-center mt-3">
                                <span class="forgot-pass"><a href="#">Forgot Username/Password?</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                <?php if ($redirect === true) { ?>
                    setTimeout(function() {
                        window.location.href = "admin/dashboard.php";  // Redirect to dashboard or home page
                    }, 1000);  // 1 seconds delay
                <?php } ?>
            <?php } ?>
        });
    </script>
</body>
</html>