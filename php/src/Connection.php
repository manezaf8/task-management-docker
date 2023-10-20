<?php

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
    $dbHost = 'dbhost'; //from your docker compose file
    $dbName = 'DBname';
    $dbUser = 'user';
    $dbPassword = 'pass';

    $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
} catch (\Throwable $th) {
    echo "An error occurred while trying to connect to the database... check your DB Info!!!";
}
