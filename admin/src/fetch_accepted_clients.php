<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digital_solutions_cell";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if this is a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the ID is provided
    if (isset($data->id)) {
        $id = $data->id;

        // Prepare the SQL statement for deletion
        $stmt = $conn->prepare("DELETE FROM client_applications WHERE id = ?");
        $stmt->bind_param("s", $id); // Assuming ID is a string; adjust if it's an integer

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete client.']);
        }

        // Close the statement
        $stmt->close();
        $conn->close();
        exit; // Exit after handling the deletion request
    } else {
        echo json_encode(['success' => false, 'message' => 'ID not provided.']);
        $conn->close();
        exit;
    }
}

// Fetching clients with status "Accept"
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if clientId is provided to fetch specific client details
    if (isset($_GET['clientId'])) {
        $clientId = $_GET['clientId'];
        
        // Prepare the SQL statement to fetch the client details
        $stmt = $conn->prepare("SELECT * FROM client_applications WHERE id = ?");
        $stmt->bind_param("s", $clientId); // Assuming ID is a string; adjust if it's an integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the client details
        if ($result->num_rows > 0) {
            $client = $result->fetch_assoc();
            echo json_encode(['success' => true, 'client' => $client]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Client not found.']);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        exit; // Exit after handling the fetch request
    }

    // Fetch all clients with status "Accept"
    $query = "SELECT id, name, email, phone FROM client_applications WHERE status = 'Accept'";
    $result = $conn->query($query);

    $clients = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }

    // Return the fetched clients as JSON
    echo json_encode(['success' => true, 'clients' => $clients]);
}

// Close the connection
$conn->close();
?>
