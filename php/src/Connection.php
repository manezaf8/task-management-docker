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

// Database credentials
$dbHost = 'db';
$dbName = 'ekomi';
$dbUser = 'admin';
$dbPassword = 'admin124';

$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
