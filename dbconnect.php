<?php
include_once "config.php";

try {
    // Create a connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    // Connection test
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}