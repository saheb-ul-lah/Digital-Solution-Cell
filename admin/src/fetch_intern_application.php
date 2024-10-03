<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digital_solutions_cell";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get application ID from the query string
$applicationId = isset($_GET['applicationId']) ? $_GET['applicationId'] : die(json_encode(null));

// Prepare and execute the SQL statement
$sql = "SELECT * FROM internship_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicationId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the application data
if ($result->num_rows > 0) {
    $application = $result->fetch_assoc();
    echo json_encode($application);
} else {
    echo json_encode(null); // No application found
}

// Close the connection
$stmt->close();
$conn->close();
?>
