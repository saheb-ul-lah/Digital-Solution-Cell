<?php

function process_form($conn, $table_name, $fields, $file_fields = []) {
    // Handle file uploads
    foreach ($file_fields as $file_field) {
        if (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] == 0) {
            $file_type = $_FILES[$file_field]['type'];
            $file_name = $_FILES[$file_field]['name'];

            // Sanitize file name
            $safe_file_name = preg_replace("/[^a-zA-Z0-9.-]/", "_", $file_name);
            $target_dir = determine_upload_directory($file_type);

            // Automatically create folder if it doesn't exist
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $target_file = $target_dir . $safe_file_name;

            if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $target_file)) {
                // Assign file path to fields array
                $fields['file_path'] = $target_file;
            } else {
                log_error("Failed to move uploaded file.");
                return "Failed to move uploaded file.";
            }
        } else {
            log_error("File upload error: " . $_FILES[$file_field]['error']);
            return "File upload error.";
        }
    }

    // Prepare SQL query
    $placeholders = implode(', ', array_fill(0, count($fields), '?'));
    $field_names = implode(', ', array_keys($fields));

    $stmt = $conn->prepare("INSERT INTO $table_name ($field_names) VALUES ($placeholders)");

    if ($stmt === false) {
        log_error("Error preparing statement: " . $conn->error);
        return "Error preparing statement.";
    }

    // Bind parameters
    $types = str_repeat('s', count($fields));
    if (!$stmt->bind_param($types, ...array_values($fields))) {
        log_error("Error binding parameters: " . $stmt->error);
        return "Error binding parameters.";
    }

    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        return "Form submitted successfully!";
    } else {
        log_error("Error executing statement: " . $stmt->error);
        return "Error executing statement.";
    }
}

function determine_upload_directory($file_type) {
    if (strpos($file_type, 'pdf') !== false) {
        return "uploads/pdfs/";
    } elseif (strpos($file_type, 'image') !== false) {
        return "uploads/images/";
    } else {
        return "uploads/other_files/";
    }
}
?>
