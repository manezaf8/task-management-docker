<?php

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

// Include the Task class and necessary files
require 'Task.php';
require 'Connection.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $userId  = null;
    $taskId  = null;

    header("Location: viewAllTasks.php?id={$taskId}&edit_success=1");

    // Get the task ID from the form
    $taskId = $_POST['id'];

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }

    // Create an instance of the Task class
    $task = new Task();

    $currentDate = date('Y-m-d H:i:s');
    $dueDate = $_POST['due_date'];

    // Use setters to update task properties
    $task->setId($taskId);
    $task->setTitle($_POST['title']);
    $task->setDescription($_POST['description']);

    if (strtotime($dueDate) > strtotime($currentDate)) {
        // Due date is in the future, it's valid
        $task = new Task();
        $task->setDueDate($dueDate);
        // ...other properties and save logic
    } else {
        // Display an error message or take appropriate action
        echo "Due date must be in the future.";
    }    

    $task->setUserId($userId);
    $task->setCompleted(isset($_POST['completed']) ? 1 : 0);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit Task</h1>

        <!-- Display success message if present in the URL -->
        <?php
        if (isset($_GET['edit_success']) && $_GET['edit_success'] == 1) {
            echo '<div class="alert alert-success">Task ' . $task->getTaskId() . ' edited successfully!</div>';
        }
        ?>

        <!-- Task edit form -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $task->getTitle(); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $task->getDescription(); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="due_date" class="col-sm-2 control-label">Due Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo $task->getDueDate(); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="completed" class="col-sm-2 control-label">Completed:</label>
                <div class="col-sm-10">
                    <input type="checkbox" id="completed" name="completed" <?php echo $task->isCompleted() ? 'checked' : ''; ?>>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>