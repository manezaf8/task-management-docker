<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */


require 'Connection.php'; // Include the database connection file
require 'Users.php'; // Include the User class

// Check if the user is already logged in, then redirect to viewAllTasks.php
if (isset($_SESSION['user_id'])) {
    header('Location: viewAllTasks.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // User clicked the "Log In" button
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Create an instance of the User class
        $user = new User();

        // Authenticate the user
        if ($user->login($email, $password)) {
            // User is authenticated, redirect to viewAllTasks.php
            header('Location: viewAllTasks.php');
            exit();
        } else {
            // Authentication failed, show an error message
            $loginError = 'Invalid email or password check your email or reset.';
        }
    } elseif (isset($_POST['create'])) {
        // User clicked the "Create User" button
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();

        // Check if the password meets certain criteria (e.g., length, complexity)
        if ($user->validatePassword($password)) {
            // Password is valid, create the user
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($password);

            if ($user->save()) {
                // User created successfully
                $createUserSuccess = 'User created successfully!';
            } else {
                // Database error
                $createUserError = 'An error occurred while creating the user.';
            }
        } else {
            // Password is invalid
            $createUserError = 'Invalid password. Password must be at least 8 characters long and contain a mix of uppercase, lowercase letters, and numbers.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - Landing Page</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="includes/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div class="container">
        <div class="login-container">
            <!-- Heading with background -->
            <div class="heading-container">
                <!-- <h1>Welcome to Task Management</h1> -->
            </div>
            <!-- <p>Login or Register:</p> -->

            <?php
            if (isset($_SESSION['registration_error'])) {
                // Use SweetAlert to display the error message
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "' . $_SESSION['registration_error'] . '"
                        });
                    </script>';
                // Clear the session variable
                unset($_SESSION['registration_error']);
            }
            ?>

            <?php if (isset($_SESSION['registration_success'])) : ?>
                <div class="alert alert-success"><?php echo $_SESSION['registration_success']; ?></div>
                <?php unset($_SESSION['registration_success']); // Clear the message after displaying
                ?>
            <?php endif; ?>

            <div class="row" id="formLogin">
                <div class="col-md-6 login-form">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="loginForm">
                        <h3 style="padding-bottom: 20px;"> Log In To The Task Management</h3>
                        <!-- Add login form fields here -->
                        <div class="form-group">
                            <label for="loginEmail">Email:</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password:</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" name="login">Log In</button>
                                
                                <p class="m-0 d-inline">  <a href="forgotPassword.php">Forgot Password?</a></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p class="m-0 d-inline">Not a member?</p>
                                <button class="btn btn-success" data-toggle="modal" data-target="#registerModal">Register</button>
                            </div>
                        </div>

                        <?php if (isset($loginError)) : ?>
                            <p class="text-danger"><?php echo $loginError; ?></p>
                        <?php endif; ?>
                        <?php if (isset($createUserError)) : ?>
                            <p class="text-danger"><?php echo $createUserError; ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="registerModalLabel">Register</h4>
                </div>
                <div class="modal-body">
                    <!-- Registration form -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="createUserForm">
                        <div class="form-group">
                            <label for="createName">Name:</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="createEmail">Email:</label>
                            <input type="email" class="form-control" id="createEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="createPassword">Password:</label>
                            <input type="password" class="form-control" id="createPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="create">Create User</button>
                        <?php if (isset($createUserSuccess)) : ?>
                            <p class="text-success"><?php echo $createUserSuccess; ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="includes/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>