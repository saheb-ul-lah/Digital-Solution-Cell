<?php
include 'db_connect.php';
include 'process_form.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = db_connect();
    $fields = [
        'name' => $_POST['name'] ?? null,
        'email' => $_POST['email'] ?? null,
        'message' => $_POST['message'] ?? null,
    ];
    echo process_form($conn, 'contact_us', $fields);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>
    <form method="POST" action="contact.php">
        <label>Name: </label><input type="text" name="name" required><br>
        <label>Email: </label><input type="email" name="email" required><br>
        <label>Message: </label><textarea name="message" required></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
