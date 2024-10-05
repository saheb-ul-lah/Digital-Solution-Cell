<?php
// Set header to return JSON response
header('Content-Type: application/json');

// Connect to the database
$conn = new mysqli("localhost", "root", "", "digital_solutions_cell");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get the JSON body from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if client ID is provided
if (isset($data['id'])) {
    $client_id = $data['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM client_applications WHERE id = ?");
    $stmt->bind_param("i", $client_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Client deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete client']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Client ID not provided']);
}

$conn->close();
?>
