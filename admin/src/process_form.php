<?php

function process_form($conn, $table_name, $fields, $file_fields = []) {
    // Handle file uploads first
    foreach ($file_fields as $file_field) {
        if (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] == 0) {
            $file_type = $_FILES[$file_field]['type'];
            $file_name = $_FILES[$file_field]['name'];

            // Sanitize file name
            $safe_file_name = preg_replace("/[^a-zA-Z0-9.-]/", "_", $file_name);

            // Choose folder based on file type
            if (strpos($file_type, 'pdf') !== false) {
                $target_dir = "uploads/pdfs/";
            } elseif (strpos($file_type, 'image') !== false) {
                $target_dir = "uploads/images/";
            } else {
                $target_dir = "uploads/other_files/";
            }

            // Automatically create folder if it doesn't exist
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $target_file = $target_dir . $safe_file_name;
            if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $target_file)) {
                // Assign file path to fields array
                $fields['file_path'] = $target_file; // Use the correct field name here
            } else {
                return "Failed to move uploaded file.";
            }
        } else {
            // If the file upload field exists but is empty, set it to null
            $fields['file_path'] = null; // Set the file path to null if no file is uploaded
        }
    }

    // Prepare SQL query
    $placeholders = implode(', ', array_fill(0, count($fields), '?'));
    $field_names = implode(', ', array_keys($fields));

    $stmt = $conn->prepare("INSERT INTO $table_name ($field_names) VALUES ($placeholders)");

    if ($stmt === false) {
        return "Error preparing statement: " . $conn->error;
    }

    // Determine parameter types for binding
    $types = '';
    foreach ($fields as $field) {
        $types .= 's'; // Assuming all fields are strings; modify if you have different types
    }

    // Bind parameters
    if (!$stmt->bind_param($types, ...array_values($fields))) {
        return "Error binding parameters: " . $stmt->error;
    }

    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        return "Form submitted successfully!";
    } else {
        $error = "Error: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}
?>
