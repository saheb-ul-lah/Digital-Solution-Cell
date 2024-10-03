<?php
// Include database connection
include 'db_connect.php';

// Fetch all projects from the 'created_projects' table
$sql = "SELECT * FROM created_projects";
$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    // Loop through each row and push to projects array
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Return the data as a JSON object
echo json_encode($projects);

// Close the database connection
$conn->close();
?>
