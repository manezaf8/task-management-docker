<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

require 'Connection.php'; // Include the database connection file
// Include the Task class and necessary files
require 'Task.php';
require 'Users.php';
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
    $taskId  = null;

    header("Location: viewAllTasks.php?id={$taskId}&edit_success=1");

    // Get the task ID from the form
    $taskId = $_POST['id'];

    $assignedUserName = $_POST['assign_to'];

    // Create an instance of the Task class
    $task = new Task();

    $currentDate = date('Y-m-d H:i:s');
    $dueDate = $_POST['due_date'];

    // Use setters to update task properties
    $task->setId($taskId);
    $task->setTitle($_POST['title']);
    $task->setDescription($_POST['description']);
    $task->setDueDate($dueDate);
    $task->setCompleted(isset($_POST['completed']) ? 1 : 0);
    $task->setAssignedTo($assignedUserName); // Set the assigned user's ID

    // Update the task in the database
    if ($task->update()) {
        // Redirect back to edit page with success message
        echo "Updated successfully!";
    }
}

// Fetch the task details for the given ID
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Create an instance of the Task class and fetch the task by ID
    $task = Task::getTaskById($taskId);

    $dueDate = date('Y-m-d', strtotime($task->getDueDate()));

    if (!$task) {
        // Handle the case where the task with the provided ID does not exist
        header("Location: viewAllTasks.php");
        exit();
    }
} else {
    // Handle the case where ID is not provided, perhaps show an error message or redirect
    header("Location: viewAllTasks.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Task - eKomi Tasks management</title>
    <link rel="icon" type="image/x-icon" href="images/fav.png">
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
                                     <li><strong>City:</strong> <?php echo isset($weatherData["name"]) ? $weatherData["name"] : "Sorry!! Your City can't be pulled by OpenWeather, update with the nearest city"; ?></li>
                                    <li> <strong>Current Temp</strong>: <?php echo isset($weatherData["main"]["temp"]) ? $weatherData["main"]["temp"] . "°C" : ""; ?></li>
                                    <li> <strong>Weather:</strong> <?php echo isset($weatherData["weather"][0]["description"]) ? $weatherData["weather"][0]["description"] : ""; ?></li>
                                </ul>
                            </div>
                        </span>
                        <ul class="crumb">
                            <li><a href="viewAllTasks.php">Home</a></li>
                            <li class="sep">/</li>
                            <li>Edit Tasks</li>
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
                        <h2>Edit Tasks</h2>
                    </div>
                    <hr class="blank">

                    <!-- Task edit form -->
                    <form style="width: 75%;" id="editUser loginForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

                        <div class="form-group">
                            <label for="title" class="col-sm-2">Title:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $task->getTitle(); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $task->getDescription(); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="due_date" class="col-sm-2 ">Due Date:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo $dueDate; ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="completed" class="col-sm-2">Completed:</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="completed" name="completed" <?php echo $task->isCompleted() ? 'checked' : ''; ?>> Completed
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="assign_to" class="col-sm-2">Assigned To:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="assign_to" name="assign_to">
                                    <?php
                                    // Assume you have a function to fetch user names from the database
                                    $userNames = $users->getUsersFromDatabase(); 

                                    foreach ($userNames as $userName) {
                                        echo '<option value="' . $userName['name'] . '">' . $userName['name'] . '</option>';
                                    }
                                        ?>
                                    </select>
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
                            &copy; Copyright  <?php echo date("Y") ?> - Designed by Maneza F8
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