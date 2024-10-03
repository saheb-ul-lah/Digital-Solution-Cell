<?php
// Include database connection
include 'db_connect.php';

// Fetching the project details if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];

    // SQL query to fetch project data
    $sql = "SELECT * FROM created_projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
        echo json_encode($project);  // Return the project data in JSON format
    } else {
        echo json_encode(['error' => 'Project not found']);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Updating the project details if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
        exit();
    }

    // Extract project data
    $projectId = $data['projectId'];
    $title = $data['projectTitle'];
    $assignedTo = $data['assignedTo'];
    $status = $data['projectStatus'];
    $completionDate = date('Y-m-d', strtotime($data['completionDate']));

    // SQL query to update project details
    $sql = "UPDATE created_projects SET project_title = ?, project_manager = ?, project_status = ?, completion_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $assignedTo, $status, $completionDate, $projectId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
