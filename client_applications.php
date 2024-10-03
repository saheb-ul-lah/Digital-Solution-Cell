<?php
// Include database connection
include 'db_connect.php';

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $organisation = $_POST['organisation'];
    $message = $_POST['message'];

    // Create the client_applications_uploads directory if it doesn't exist
    $target_dir = "client_applications_uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory with appropriate permissions
    }

    // File upload handling
    $requirement_file = $target_dir . basename($_FILES["requirement-file"]["name"]);
    $fileType = strtolower(pathinfo($requirement_file, PATHINFO_EXTENSION));
    
    // Check if the file is a valid PDF and within size limit
    if ($fileType != "pdf" || $_FILES["requirement-file"]["size"] > 2 * 1024 * 1024) {
        $response['message'] = "Invalid file. Only PDF files under 2MB are allowed.";
    } else {
        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["requirement-file"]["tmp_name"], $requirement_file)) {
            // SQL query to insert form data into the client_applications table
            $sql = "INSERT INTO client_applications (name, designation, email, phone, address, organisation, requirement_file, message) 
                    VALUES ('$name', '$designation', '$email', '$phone', '$address', '$organisation', '$requirement_file', '$message')";

            if ($conn->query($sql) === TRUE) {
                $response = ['status' => 'success', 'message' => "Application submitted successfully!"];
            } else {
                $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $response['message'] = "File upload failed.";
        }
    }
}

// Close the connection
$conn->close();

// If the response was set, echo JavaScript to display the message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Submission Response</title>
        <style>
            .message-box {
                position: fixed;
                top: 20px; /* Adjust as necessary */
                left: 50%;
                transform: translateX(-50%);
                padding: 15px 25px;
                color: white;
                border-radius: 5px;
                z-index: 1000;
                opacity: 1;
                transition: opacity 0.5s ease;
            }

            .message-box.success {
                background-color: green;
            }

            .message-box.error {
                background-color: red;
            }
        </style>
    </head>
    <body>
        <script>
            function showMessage(message, status) {
                const messageBox = document.createElement("div");
                messageBox.className = "message-box " + status;
                messageBox.innerText = message;
                document.body.appendChild(messageBox);

                // Display for 2 seconds
                setTimeout(() => {
                    messageBox.style.opacity = 0; // Fade out
                    setTimeout(() => {
                        messageBox.remove(); // Remove from DOM after fading out
                        window.location.href = "index.html"; // Redirect to index.html
                    }, 500); // Wait for fade-out to complete before removing
                }, 2000);
            }

            showMessage("' . addslashes($response['message']) . '", "' . $response['status'] . '");
        </script>
    </body>
    </html>';
    exit; // Stop the script execution after displaying the message
}
?>
