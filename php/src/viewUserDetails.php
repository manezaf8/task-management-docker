<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */


require 'Task.php'; // Include the Task class
// Include the weather integration file
require 'weather.php';

// Define your OpenWeatherMap API key and city
$apiKey = '4e8f3a3d6960a08f787632c2eca2e89f';
$city = 'Cape Town';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
        <!-- content goes here -->
        <div class="container">
        <?php $weatherData = getCurrentWeather($city, $apiKey); ?>

        <!-- Styling for weather information -->
        <div style="background-color: #f0f0f0; padding: 20px; text-align: center;">
            <h3>Current Weather</h3>
            <p>City: <?php echo $weatherData["name"]; ?></p>
            <p>Current Temp: <?php echo $weatherData["main"]["temp"]; ?></p>
            <p>Weather: <?php echo $weatherData["weather"][0]["description"]; ?></p>
        </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php

                require 'Users.php'; // Include the User class

                // Check if the user_id parameter is set in the URL
                if (isset($_GET['user_id'])) {
                    $user_id = $_GET['user_id'];

                    // Create an instance of the User class
                    $user = new User();

                    // Use a function to fetch user details by user_id
                    $userData = $user->getUserById($user_id);

                    if ($userData) {
                        // User details found, display them
                        $name = $userData['name'];
                        $email = $userData['email'];

                        echo "<h1>User Details</h1>";
                        echo "<div class='panel panel-default'>";
                        echo "<div class='panel-heading'>User Information</div>";
                        echo "<div class='panel-body'>";
                        echo "<p><strong>Name:</strong> $name</p>";
                        echo "<p><strong>Email:</strong> $email</p>";
                        echo "</div>";
                        echo "</div>";

                        // Add a "Return to All Tasks" button
                        echo "<a href='viewAllTasks.php' class='btn btn-primary'>Return to All Tasks</a>";
                    } else {
                        // User not found, display an error message
                        echo "<div class='alert alert-danger'>User not found.</div>";
                    }
                } else {
                    // user_id parameter not set, display an error message
                    echo "<div class='alert alert-danger'>Invalid request. Please provide a user ID.</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
