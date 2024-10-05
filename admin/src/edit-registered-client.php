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

// Handle GET request to fetch client data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['clientId'])) {
    $clientId = $_GET['clientId'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM client_applications WHERE id = ?");
    $stmt->bind_param("s", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the client details
        $client = $result->fetch_assoc();
        echo json_encode(['success' => true, 'client' => $client]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client not found.']);
    }

    // Close the statement
    $stmt->close();
    exit;
}

// Handle POST request to update client data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $clientId = $_POST['clientId'];
    $clientName = $_POST['clientName'];
    $clientDesignation = $_POST['clientDesignation'];
    $clientOrganisation = $_POST['clientOrganisation'];
    $clientEmail = $_POST['clientEmail'];
    $clientPhone = $_POST['clientPhone'];
    $clientAddress = $_POST['clientAddress'];
    $assignedTo = $_POST['assignedTo'];
    // $clientProgress = $_POST['clientProgress'];

    // Prepare and execute the SQL update statement
    $stmt = $conn->prepare("UPDATE client_applications SET name = ?, designation = ?, organisation = ?, email = ?, phone = ?, address = ?, project_assigned_to = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $clientName, $clientDesignation, $clientOrganisation, $clientEmail, $clientPhone, $clientAddress, $assignedTo, $clientId);

    if ($stmt->execute()) {
        // On success, render the success page with transition message and redirect script
        echo '<div id="successMessage" class="success-banner">Client details updated successfully!</div>';
        echo '<script>
                // Show success message for 1 second
                document.getElementById("successMessage").style.display = "block";
                setTimeout(function() {
                    document.getElementById("successMessage").classList.add("fade-out");
                    // After 1 second, redirect to registered-clients.html
                    setTimeout(function() {
                        window.location.href = "registered-clients.html";
                    }, 1000);
                }, 1000);
              </script>';
    } else {
        echo '<div id="errorMessage" class="error-banner">Failed to update client details.</div>';
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
<style>
    .success-banner {
        display: none;
        background-color: #28a745;
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 16px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        opacity: 1;
        transition: opacity 1s ease-in-out;
    }

    .fade-out {
        opacity: 0;
    }

    .error-banner {
        display: block;
        background-color: #dc3545;
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 16px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }
</style>
