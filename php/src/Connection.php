<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @package   Task Management
 * @author    Ntabethemba Ntshoza
 * @date      11-10-2023
 * @copyright Copyright © 2023 VMP By Maneza
 */

if (session_id() === '') {
    session_start();
}

try {
    // Database credentials
    $dbHost = 'db'; //from your docker compose file
    $dbName = 'ekomi';
    $dbUser = 'admin';
    $dbPassword = 'admin124';

    $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
} catch (\Throwable $th) {
    echo "An error occurred while fetching weather data. {$th}";
}
