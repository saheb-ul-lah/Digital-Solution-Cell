<?php
function db_connect() {
    $servername = "localhost";
    $username = "root";  // Update according to your configuration
    $password = "";      // Update according to your configuration
    $dbname = "restaurant_website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        log_error("Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function log_error($message) {
    $log_file = 'logs/error_log.txt';
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}
?>
