<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */


require 'Task.php'; // Include the Task class
require 'Users.php'; // Include the user class
require 'weather.php'; // Include the weather integration file

// Define your OpenWeatherMap API key and city
$users = new User();
$apiKey = '4e8f3a3d6960a08f787632c2eca2e89f';
$city =  $users->getWeatherCity();

$taskClass = new Task();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - View All Tasks</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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

        <h1 style=" text-align: center;">Listed Tasks</h1>

        <?php if (isset($_SESSION['login_success'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['login_success']; ?></div>
            <?php unset($_SESSION['login_success']); // Clear the message after displaying 
            ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['task_saved'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['task_saved']; ?></div>
            <?php unset($_SESSION['task_saved']); // Clear the message after displaying 
            ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['task_updated'])) : ?>
            <div class="alert alert-success"><?php echo $_SESSION['task_updated']; ?></div>
            <?php unset($_SESSION['task_updated']); // Clear the message after displaying 
            ?>
        <?php endif; ?>

        <div id="logoutAndNewTask">
            <?php echo '<a href="createTask.php" class="btn btn-primary">Create a Task</a>'; ?>
            <button onclick="logoutNow()" class="btn btn-danger" style="margin-left: 1em;">Logout</button>
        </div>

        <?php
        // Check if the delete_success query parameter is set
        if (isset($_GET['delete_success']) && $_GET['delete_success'] == 1) {
            echo '<div class="alert alert-success">Task ' . $taskClass->getId() . ' deleted successfully!</div>';
        }
        ?>

        <?php
        $alltasks = $taskClass->getAllTasks();
        // Check if there are no tasks, and display the "Create Task" button if true
        if (empty($alltasks)) {
            echo '<a  href="createTask.php" class="btn btn-primary">Create a Task</a>';
        } else {
        ?>

            <table id="taskTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th data-orderable="false">Description</th>
                        <th>Due Date</th>
                        <th>Completed</th>
                        <th>User ID</th>
                        <th data-orderable="false">Edit</th>
                        <th data-orderable="false">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tasks = $taskClass->getAllTasks();
                    ?>
                    <!-- Loop through your tasks and display them as table rows -->
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?php echo $task->getId(); ?></td>
                            <td><?php echo $task->getTitle(); ?></td>
                            <td><?php echo $task->getDescription(); ?></td>
                            <td><?php echo $task->getDueDate(); ?></td>
                            <td><?php echo $task->isCompleted() ? 'Yes' : 'No'; ?></td>
                            <td>
                                <!-- Display user ID as a clickable link -->
                                <a href="viewUserDetails.php?user_id=<?php echo $task->getUserId(); ?>">
                                    <?php echo $task->getUserId(); ?>
                                </a>
                            </td>
                            <td>
                                <!-- Edit button -->
                                <button onclick="editTask(<?php echo $task->getId(); ?>)" class="btn btn-primary btn-sm">Edit</button>
                            </td>
                            <td>
                                <!-- Delete button -->
                                <button onclick="deleteTask(<?php echo $task->getId(); ?>)" class="btn btn-danger btn-sm">Delete</button>
                            </td>

                            <!-- JavaScript function to confirm and delete the task -->
                            <script>
                                function deleteTask(taskId) {
                                    if (confirm("Are you sure you want to delete this task?")) {
                                        // Redirect to deleteTask.php with the task ID
                                        window.location.href = "deleteTask.php?id=" + taskId;
                                    }
                                }

                                function logoutNow() {
                                    if (confirm("Are you sure you want to logout?")) {
                                        // Redirect to logout.php
                                        window.location.href = "logout.php";
                                    }
                                }


                                function editTask(taskId) {
                                    if (confirm("Are you sure you want to edit this task?")) {
                                        // Redirect to deleteTask.php with the task ID
                                        window.location.href = "editTask.php?id=" + taskId;
                                    }
                                }
                            </script>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        } // End of else block
        echo '<a href="usersList.php" class="btn btn-primary">View All Users</a>';
        ?>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Initialize DataTables -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#taskTable').DataTable();
        });
    </script>

</body>

</html>