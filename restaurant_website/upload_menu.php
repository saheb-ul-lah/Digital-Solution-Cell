<?php
include 'db_connect.php';
include 'process_form.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = db_connect();
    $fields = [
        'menu_name' => $_POST['menu_name'] ?? null,
        'description' => $_POST['description'] ?? null,
        'file_path' => null,
        'category' => $_POST['category'] ?? null,
        'is_available' => isset($_POST['is_available']) ? 1 : 0,
    ];

    // Process form
    $result = process_form($conn, 'menu_uploads', $fields, ['file']);
    echo $result;
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Menu</title>
</head>
<body>
    <h1>Upload Menu</h1>
    <form method="POST" action="upload_menu.php" enctype="multipart/form-data">
        <label>Menu Name: </label><input type="text" name="menu_name" required><br>
        <label>Description: </label><textarea name="description"></textarea><br>
        <label>Category: </label>
        <select name="category" required>
            <option value="Appetizers">Appetizers</option>
            <option value="Main Course">Main Course</option>
            <option value="Desserts">Desserts</option>
        </select><br>
        <label>Available: </label><input type="checkbox" name="is_available"><br>
        <label>Upload Menu File (PDF/Image): </label><input type="file" name="file" accept=".pdf,image/*" required><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
