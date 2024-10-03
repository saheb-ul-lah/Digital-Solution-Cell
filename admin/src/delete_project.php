<?php
// Include database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the project ID from the AJAX request
    $projectId = $_POST['id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM created_projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectId);

    if ($stmt->execute()) {
        // Success: Respond with success message
        echo json_encode(['success' => true]);
    } else {
        // Error: Respond with error message
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If not a POST request, return an error
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
