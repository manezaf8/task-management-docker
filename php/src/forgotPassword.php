<?php
/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

include "Users.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the email is submitted
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $user = new User();

        $user->setEmail($email);

        if ($user->forgotPassword($email)) {
 echo "<style>
 #forgotPassword {
     display: none;
 }
</style>";
            session_destroy();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="icon" type="image/x-icon" href="images/fav.png">
    <!-- Include your CSS and Bootstrap links here -->

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1 class="text-center">Forgot Password</h1>
                <p class="text-center">Enter your email to reset your password:</p>

                <?php if (isset($_SESSION['reset_password'])) : ?>
                    <div class="alert alert-success text-center"><?php echo $_SESSION['reset_password']; ?></div>
                    <?php unset($_SESSION['reset_password']); // Clear the message after displaying wrong_email
                    ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['wrong_email'])) : ?>
                    <div class="alert alert-success text-center"><?php echo $_SESSION['wrong_email']; ?></div>
                    <?php unset($_SESSION['wrong_email']); // Clear the message after displaying wrong_email
                    ?>
                <?php endif; ?>

                <?php if (isset($emailNotExistsMessage)) : ?>
                    <div class="alert alert-danger text-center"><?php echo $emailNotExistsMessage; ?></div>
                <?php endif; ?>

                <form id="forgotPassword" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="reset">Reset Password</button>
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

