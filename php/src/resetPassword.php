<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

 
include 'Users.php'; // Include your User class or the file with user-related functions.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data (new password)
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the passwords match
    if ($newPassword === $confirmPassword) {
        // Check if the provided email and token are valid
        if (isset( $_GET['email']) && isset( $_GET['token'])){
            $email = $_GET['email']; // You can get these from the query parameters.
            $token = $_GET['token']; 

        $user = new User(); // Assuming you have a User class with appropriate methods.

        if ($user->isValidPasswordResetRequest($email, $token)) {
            // Update the user's password (ensure it's securely hashed)
            $user->updatePassword($email, $newPassword);

            // Password updated successfully
            $resetPasswordSuccess = "Password reset successfully. You will be redirected to the login page in 3 seconds. If not, click <a href='index.php'>here</a>.";

            echo $resetPasswordSuccess;
            echo '<meta http-equiv="refresh" content="3;url=index.php">';
            
            exit; // Terminate script execution
        } else {
            // Invalid request
            $resetPasswordError  = "Invalid or expired reset link.";
        }
    } else{
        $resetPasswordError = "Email or token is not valid make sure the link is valid or <a href='index.php'>log in again</a>";
    }
    } else {
        // Passwords don't match
        $resetPasswordError = "Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <!-- Include your CSS and Bootstrap links here -->

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="includes/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php if (isset($_SESSION['reset_password'])) : ?>
                    <div class="alert alert-success"><?php echo $_SESSION['reset_password']; ?></div>
                    <?php unset($_SESSION['reset_password']); // Clear the message after displaying
                    ?>
                <?php endif; ?>

                <h1 class="text-center">Reset Your Password</h1>
                <?php if (isset($resetPasswordSuccess)) : ?>
                            <p class="text-success"><?php echo $resetPasswordSuccess; ?></p>
                        <?php endif; ?>

                        <?php if (isset($resetPasswordError)) : ?>
                            <p class="text-success"><?php echo $resetPasswordError; ?></p>
                        <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" class="form-control" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include your scripts or links to JavaScript files if needed -->

    <!-- Include Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>