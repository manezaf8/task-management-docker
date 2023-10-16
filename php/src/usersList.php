<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */


require 'Users.php'; // Include the Task class
// Include the weather integration file
require 'weather.php';

// User class
$usersClass = new User();

// Define your OpenWeatherMap API key and city
$apiKey = '4e8f3a3d6960a08f787632c2eca2e89f';
$city =  $usersClass->getWeatherCity();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - View All Users</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/styles.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <!-- content goes here -->
    <div class="container">
        <?php $weatherData = getCurrentWeather($city, $apiKey); ?>

        <!-- Styling for weather information -->
        <div style="background-color: #f0f0f0; padding: 20px; text-align: center;">
            <h3>Current Weather</h3>
            <p>City: <?php echo isset($weatherData["name"]) ? $weatherData["name"] : ""; ?></p>
            <p>Current Temp: <?php echo isset($weatherData["main"]["temp"]) ? $weatherData["main"]["temp"] : ""; ?></p>
            <p>Weather: <?php echo isset($weatherData["weather"][0]["description"]) ? $weatherData["weather"][0]["description"] : ""; ?></p>
        </div>

        <h1 style=" text-align: center;">Listed Users</h1>

        <div id="logoutAndNewTask">
            <?php echo '<a href="createTask.php" class="btn btn-primary">Create a Task</a>'; ?>
            <button onclick="logoutNow()" class="btn btn-danger" style="margin-left: 1em;">Logout</button>
        </div>


        <?php
        $allusers = $usersClass->getallusers();
        // Check if there are no tasks, and display the "Create Task" button if true
        if (empty($allusers)) {
            echo '<a  href="createTask.php" class="btn btn-primary">Create a Task</a>';
        } else {
        ?>

            <table id="taskTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User City</th>
                        <th>User Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $usersClass->getallusers();
                    ?>
                    <!-- Loop through your tasks and display them as table rows -->
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user->getUserId(); ?></td>
                            <td><?php echo $user->getName(); ?></td>
                            <td><?php echo $user->getCity(); ?></td>
                            <td><?php echo $user->getEmail(); ?></td>

                            <!-- JavaScript function to confirm and delete the task -->
                            <script>
                                function logoutNow() {
                                    if (confirm("Are you sure you want to logout?")) {
                                        // Redirect to logout.php
                                        window.location.href = "logout.php";
                                    }
                                }
                            </script>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        } // End of else block
        echo '<a href="viewAllTasks.php" class="btn btn-primary">View All Tasks</a>';
        ?>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Initialize DataTables -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#taskTable').DataTable();
        });
    </script>

</body>

</html>