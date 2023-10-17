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
        $city = $_POST['city'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();

        // Check if the password meets certain criteria (e.g., length, complexity)
        if ($user->validatePassword($password)) {
            // Password is valid, create the user
            $user->setName($name);
            $user->setCity($city);
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
    <meta charset="utf-8">
    <title>Login / Register - eKomi Tasks management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive Minimal Bootstrap Theme">
    <meta name="keywords" content="responsive,minimal,bootstrap,theme">
    <meta name="author" content="">

    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
    <link rel="stylesheet" href="css/ie.css" type="text/css">
	<![endif]-->

    <!-- CSS Files
    ================================================== -->
    <link rel="stylesheet" href="css/main.css" type="text/css" id="main-css">
    <link rel="stylesheet" href="includes/styles.css" type="text/css">


    <!-- Javascript Files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/easing.js"></script>
    <script src="js/jquery.ui.totop.js"></script>
    <script src="js/selectnav.js"></script>
    <script src="js/ender.js"></script>
    <script src="js/jquery.lazyload.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/contact.js"></script>
</head>

<body>
    <div id="wrapper">

        <!-- header begin -->
        <header>
            <div class="info">
                <div class="container">
                    <div class="row">
                        <div class="span6 info-text">
                            <strong>Phone:</strong> (111) 333 7777 <span class="separator"></span><strong>Email:</strong> <a href="#">contact@example.com</a>
                        </div>
                        <div class="span6 text-right">
                            <div class="social-icons">
                                <a class="social-icon sb-icon-facebook" href="#"></a>
                                <a class="social-icon sb-icon-twitter" href="#"></a>
                                <a class="social-icon sb-icon-rss" href="#"></a>
                                <a class="social-icon sb-icon-dribbble" href="#"></a>
                                <a class="social-icon sb-icon-linkedin" href="#"></a>
                                <a class="social-icon sb-icon-flickr" href="#"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div id="logo" style=" width: 250px; height: auto; ">
                    <div class="inner">
                        <a href="index.php">
                            <img src="images/logo.png" alt="logo"></a>
                    </div>
                </div>

                <!-- mainmenu begin -->
                <ul id="mainmenu">
                    <li><a href="viewAllTasks.php">Home</a>
                    </li>
                    <li><a href="usersList.php">View Users</a>
                    </li>
                    <li><a onclick="logoutNow()" href="#">Logout</a></li>
                </ul>
                <!-- mainmenu close -->

            </div>
        </header>
        <!-- header close -->

        <!-- subheader begin -->
        <div id="subheader">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <h1>Welcome</h1>
                        <span>Login / Signup to continue</span>
                        <ul class="crumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="sep">/</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- subheader close -->

        <!-- content begin -->
        <div id="content">
            <div class="container">
                <div class="row">

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

                    <?php if (isset($_SESSION['updated_password'])) : ?>
                        <div class="alert alert-success"><?php echo $_SESSION['updated_password']; ?></div>
                        <?php unset($_SESSION['updated_password']); // Clear the message after displaying 
                        ?>
                    <?php endif; ?>


                    <div class="span8">
                        <h3 style="padding-bottom: 20px;"> Log In To The Task Management</h3>
                        Feel free to contact us here (111) 333 7777  if you having issue.<br />
                        <br />
                        <div class="contact_form_holder">
                            <form id="contact loginForm" class="row" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                <div class="span4">
                                    <label>Email <span class="req">*</span></label>
                                    <input type="text" class="full" name="email" id="email" required />
                                    <div id="error_email" class="error">Please check your email</div>
                                </div>

                                <div class="span4">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                                </div>

                                <div class="span8">
                                    <div>
                                        <p id="btnsubmit">
                                            <button type="submit" class="btn btn-primary" name="login">Log In</button>
                                        </p>
                                        <div class="d-flex align-items-center">
                                            <p class="m-0"> <a href="forgotPassword.php">Forgot Password?</a></p>
                                            <button class="btn btn-success ml-3" data-toggle="modal" data-target="#registerModal">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

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
                                        <input type="text" class="form-control" id="name createName" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="createEmail">Your City:</label>
                                        <input type="text" class="form-control" id="city createEmail" name="city" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="createEmail">Email:</label>
                                        <input type="email" class="form-control" id="email createEmail" name="email" required>
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
            </div>
        </div>
    </div>
    </div>
    <!-- content close -->

    <!-- footer begin -->
    <footer>
        <div class="subfooter">
            <div class="container">
                <div class="row">
                    <div class="span6">
                        &copy; Copyright 2013 - Designed by Maneza F8
                    </div>
                    <div class="span6">
                        <nav>
                            <ul>
                                <li><a href="viewAllTasks.php">Home</a></li>
                                <li><a href="usersList.php">View Users</a></li>
                                <li><a onclick="logoutNow()" href="#">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- footer close -->

    </div>



</body>

</html>