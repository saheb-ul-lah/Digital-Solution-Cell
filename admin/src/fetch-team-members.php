<?php
// Database connection
$servername = "localhost";  // Update as necessary
$username = "root";  // Update as necessary
$password = "";  // Update as necessary
$dbname = "digital_solutions_cell";  // Update as necessary

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch team numbers from the database
$query = "SELECT DISTINCT team_no FROM internship_applications WHERE team_no IS NOT NULL ORDER BY team_no ASC";
$result = $conn->query($query);

$teams = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teams[] = $row['team_no'];
    }
}

// Return the team numbers as a JSON response
echo json_encode(['success' => true, 'teams' => $teams]);

$conn->close();
?>
