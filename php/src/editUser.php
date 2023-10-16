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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit user</h1>

        <!-- user edit form -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Edit Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="name" value="<?php echo $userData['name']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="due_date" class="col-sm-2 control-label">Edit City:</label>
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

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>