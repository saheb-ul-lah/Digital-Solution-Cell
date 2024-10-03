<?php
// Include database connection
include 'db_connect.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Get the input from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if a delete request is being made
if (isset($data['action']) && $data['action'] === 'delete' && isset($data['id'])) {
    $id = $data['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM client_applications WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['success' => true]); // Return success response
    } else {
        echo json_encode(['success' => false, 'error' => 'Could not delete application.']); // Return error response
    }
    $stmt->close();
    exit; // Exit after deletion
}

// Check if a status update request is being made
if (isset($data['status']) && isset($data['id'])) {
    $id = $data['id'];
    $status = $data['status'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE client_applications SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $id])) {
        echo json_encode(['success' => true]); // Return success response
    } else {
        echo json_encode(['success' => false, 'error' => 'Could not update status.']); // Return error response
    }
    $stmt->close();
    exit; // Exit after update
}

// SQL query to fetch client applications
$sql = "SELECT * FROM client_applications";
$result = $conn->query($sql);

$applications = [];

if ($result->num_rows > 0) {
    // Fetch all rows
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    echo json_encode($applications); // Return applications data in JSON format
} else {
    echo json_encode([]); // Return empty array if no applications found
}

// Close the database connection
$conn->close();
?>
