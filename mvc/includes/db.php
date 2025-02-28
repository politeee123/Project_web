<?php

function getConnection():mysqli
{
    $hostname = 'localhost';
    $dbName = 'event_management';
    $username = 'Project';
    $password = 'Project';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

require_once DATABASE_DIR . '/User.php';
require_once DATABASE_DIR . '/Attendance.php';
require_once DATABASE_DIR . '/Registration.php';
require_once DATABASE_DIR . '/Event.php';
