<?php
/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

require 'Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    $user = new User();

    

    if ($user->delete($userId)) {
        header("Location: usersList.php?delete_success=1"); // Redirect to the task list page after deletion
        exit();
    } else {
        echo "Failed to delete the user.";
    }
} else {
    echo "Invalid request.";
}
