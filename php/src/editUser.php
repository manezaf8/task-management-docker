<?php

/**
 * @package   user Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

// Include the user class and necessary files
require 'Users.php';
require 'Connection.php'; // Include the database connection file
require 'weather.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the index page
    exit; // Terminate script execution
}

$users = new User();

$apiKey = '4e8f3a3d6960a08f787632c2eca2e89f';
$city =  $users->getWeatherCity();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $userId  = null;

    header("Location: usersList.php?id={$userId}&edit_success=1");

    // Get the user ID from the form
    $userId = $_POST['id'];

    // Create an instance of the user class
    $user = new User();

    // Use setters to update user properties
    $user->setUserId($userId);
    $user->setName($_POST['name']);
    $user->setCity($_POST['city']);
    $user->setEmail($_POST['email']);


    // Update the user in the database
    if ($user->update()) {
        // Redirect back to edit page with success message
        echo "Updated successfully!";
    }
}

// Fetch the user details for the given ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // $userId = $_SESSION["user_id"];

    $user = new User();
    // Create an instance of the user class and fetch the user by ID
    $userData = $user->getUserById($userId);

    if (!$user) {
        // Handle the case where the user with the provided ID does not exist
        header("Location: usersList.php");
        exit();
    }
} else {
    // Handle the case where ID is not provided, perhaps show an error message or redirect
    header("Location: usersList.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Task - eKomi Tasks management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive Minimal Bootstrap Theme">
    <meta name="keywords" content="responsive,minimal,bootstrap,theme">
    <meta name="author" content="">

    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
    <link rel="stylesheet" href="css/ie.css" type="text/css">
	<![endif]-->

    <!-- Include DataTables CSS and JavaScript 
     =================================================-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #editUser input {
            width: 50%;
        }
    </style>
</head>

<body>
    <div id="wrapper">

        <!-- header begin -->
        <header>
            <div class="container">
                <div id="logo" style=" width: 250px; height: auto; ">
                    <div class="inner">
                        <a href="viewAllTasks.php">
                            <img src="images/logo.png" alt="logo"></a>
                    </div>
                </div>

                <!-- mainmenu begin -->
                <ul id="mainmenu">
                    <li><a href="viewAllTasks.php">Home</a>
                    </li>
                    <li><a href="usersList.php">Users</a>
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
                        <h1>Current Weather</h1>
                        <span>
                            <?php $weatherData = getCurrentWeather($city, $apiKey); ?>

                            <!-- Styling for weather information -->
                            <div>
                                <!-- <h3>Current Weather</h3> -->
                                <ul>
                                     <li><strong>City:</strong> <?php echo isset($weatherData["name"]) ? $weatherData["name"] : ""; ?></li>
                                    <li> <strong>Current Temp</strong>: <?php echo isset($weatherData["main"]["temp"]) ? $weatherData["main"]["temp"] : ""; ?></li>
                                    <li> <strong>Weather:</strong> <?php echo isset($weatherData["weather"][0]["description"]) ? $weatherData["weather"][0]["description"] : ""; ?></li>
                                </ul>
                            </div>
                        </span>
                        <ul class="crumb">
                            <li><a href="viewAllTasks.php">Home</a></li>
                            <li class="sep">/</li>
                            <li>Edit Users</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- subheader close -->

        <!-- services section begin -->
        <section id="services" data-speed="10" data-type="background">
            <div class="container">
                <div class="row">
                    <div class="text-center">
                        <h2>Edit User</h2>
                    </div>
                    <hr class="blank">

                    <!-- user edit form -->
                    <form style="width: 65%;" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">

                        <div class="form-group">
                            <label for="title" class="col-sm-2 ">Edit Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="name" value="<?php echo $userData['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="due_date" class="col-sm-2 ">Edit City:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="due_date" name="city" value="<?php echo $userData['city']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </div>
</body>

</html>