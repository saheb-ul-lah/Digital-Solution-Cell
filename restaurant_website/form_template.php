<?php

function render_form($fields, $action) {
    echo "<form method='POST' action='$action' enctype='multipart/form-data'>";
    foreach ($fields as $field) {
        switch ($field['type']) {
            case 'text':
                echo "<label>{$field['label']}:</label><input type='text' name='{$field['name']}' required><br>";
                break;
            case 'textarea':
                echo "<label>{$field['label']}:</label><textarea name='{$field['name']}' required></textarea><br>";
                break;
            case 'file':
                echo "<label>{$field['label']}:</label><input type='file' name='{$field['name']}' required><br>";
                break;
            case 'radio':
                echo "<label>{$field['label']}:</label>";
                foreach ($field['options'] as $option) {
                    echo "<input type='radio' name='{$field['name']}' value='$option' required>$option";
                }
                echo "<br>";
                break;
            case 'dropdown':
                echo "<label>{$field['label']}:</label><select name='{$field['name']}'>";
                foreach ($field['options'] as $option) {
                    echo "<option value='$option'>$option</option>";
                }
                echo "</select><br>";
                break;
            // Add more cases for other input types as needed
        }
    }
    echo "<button type='submit'>Submit</button></form>";
}
?>
