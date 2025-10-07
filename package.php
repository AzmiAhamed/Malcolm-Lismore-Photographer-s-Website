<?php
// Include database connection
include('Connection.php');

// Initialize variables for success and error messages
$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $session_type = $_POST['session-type'];
    $date = $_POST['date'];
    $message = $_POST['message'];

    // Get the price from the session type
    switch ($session_type) {
        case 'wedding':
            $price = 349.00;
            break;
        case 'wild':
            $price = 249.00;
            break;
        case 'portrait':
            $price = 199.00;
            break;
        case 'special event':
            $price = 399.00;
            break;
        default:
            $price = 0.00; // Fallback in case of an error
    }

    // Prepare SQL query with price
    $sql = "INSERT INTO bookings (name, email, phone, session_type, date, message, price) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssd", $name, $email, $phone, $session_type, $date, $message, $price);

        if ($stmt->execute()) {
            $success_message = "Booking successfully submitted!";
        } else {
            $error_message = "Error: Could not execute query.";
        }

        $stmt->close();
    } else {
        $error_message = "Error: Could not prepare query.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home Page.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Packages</title>
</head>
<body>
    <!--Model-->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                  <h5 class="modal-title" id="buyNowModalLabel">Book Your Photography Session</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <!-- Modal Body -->
              <div class="modal-body">
                  <form action="package.php" method="POST" id="bookingForm">
                      <!-- Full Name -->
                      <div class="mb-3">
                          <label for="name" class="form-label">Full Name:</label><br>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                      </div>
                      <!-- Email Address -->
                      <div class="mb-3">
                          <label for="email" class="form-label">Email Address:</label><br>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                      </div>
                      <!-- Phone Number -->
                      <div class="mb-3">
                          <label for="phone" class="form-label">Phone Number:</label><br>
                          <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                      </div>
                      <!-- Session Type -->
                      <div class="mb-3">
                          <label for="session-type" class="form-label">Session Type:</label><br>
                          <select id="session-type" name="session-type" class="form-select" required>
                              <option value="wedding" data-price="349">Wedding Photography - $349</option>
                              <option value="wild" data-price="249">Wild Photography - $249</option>
                              <option value="portrait" data-price="199">Portrait Session - $199</option>
                              <option value="special event" data-price="399">Special Events - $399</option>
                          </select>
                      </div>
                      <!-- Preferred Date -->
                      <div class="mb-3">
                          <label for="date" class="form-label">Preferred Date:</label><br>
                          <input type="date" class="form-control" id="date" name="date" required>
                      </div>
                      <!-- Additional Message -->
                      <div class="mb-3">
                          <label for="message" class="form-label">Additional Message:</label>
                          <textarea id="message" name="message" class="form-control" rows="4" placeholder="Write your message here..."></textarea>
                      </div>
                      <!-- Submit Button -->
                      <button type="submit" class="btn">Book Now</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Buy Now Button Click
        var buyNowButtons = document.querySelectorAll('button[data-bs-toggle="modal"]');
        
        buyNowButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var targetModal = document.querySelector(button.getAttribute('data-bs-target'));
                var modal = new bootstrap.Modal(targetModal);
    
                // Get the price from the button's data-price attribute
                var price = button.getAttribute('data-price');
                var sessionType;
    
                // Determine the session type based on the button's context
                if (price == '$349') {
                    sessionType = 'wedding';
                } else if (price == '$249') {
                    sessionType = 'wild';
                } else if (price == '$199') {
                    sessionType = 'portrait';
                } else if (price == '$399') {
                    sessionType = 'special event';
                }
                // Update the modal content
                document.getElementById('modal-price').textContent = 'Price: ' + data-price;
                document.getElementById('session-type').value = sessionType;
            });
        });
    </script>
    <?php
    if (!empty($success_message)) {
        echo "<script>toastr.success('{$success_message}');</script>";
    } elseif (!empty($error_message)) {
        echo "<script>toastr.error('{$error_message}');</script>";
    }
    ?>
</body>

</html>