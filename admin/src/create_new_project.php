<?php
// Include database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from form
    $project_title = $_POST['project_title'];
    $project_manager = $_POST['project_manager'];
    $project_status = $_POST['project_status'];
    $completion_date = $_POST['completion_date'];
    $project_link = isset($_POST['project_link']) ? $_POST['project_link'] : null; // Optional field

    // Prepare the SQL query
    $sql = "INSERT INTO created_projects (project_title, project_manager, project_status, completion_date, project_link) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters (s = string, d = date)
        $stmt->bind_param("sssss", $project_title, $project_manager, $project_status, $completion_date, $project_link);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                alert('Project created successfully!');
                window.location.href = 'create-new-project.html'; // Redirect after success
            </script>";
        } else {
            echo "<script>
                alert('Error creating project: " . $stmt->error . "');
                window.history.back(); // Redirect back on error
            </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>
            alert('Error preparing statement: " . $conn->error . "');
            window.history.back(); // Redirect back on error
        </script>";
    }
}

// Close the connection
$conn->close();
?>
