<?php
// Database connection
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

// Fetch distinct team numbers from the internship_applications table
$sql = "SELECT DISTINCT team_no FROM internship_applications WHERE team_no IS NOT NULL";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    $teamNumbers = [];
    // Loop through each row and store team numbers in an array
    while($row = $result->fetch_assoc()) {
        $teamNumbers[] = $row['team_no'];
    }
    // Return the result as a JSON response
    echo json_encode(['success' => true, 'teamNumbers' => $teamNumbers]);
} else {
    // If no team numbers found, return an empty array
    echo json_encode(['success' => false, 'message' => 'No team numbers found.']);
}

// Close the connection
$conn->close();
?>
