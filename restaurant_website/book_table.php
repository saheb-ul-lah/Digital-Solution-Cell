<?php
include 'db_connect.php';
include 'process_form.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = db_connect();
    $fields = [
        'name' => $_POST['name'] ?? null,
        'phone_number' => $_POST['phone_number'] ?? null,
        'number_of_people' => $_POST['number_of_people'] ?? null,
        'booking_date' => $_POST['booking_date'] ?? null,
        'booking_time' => $_POST['booking_time'] ?? null,
    ];
    echo process_form($conn, 'table_bookings', $fields);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table</title>
</head>
<body>
    <h1>Book a Table</h1>
    <form method="POST" action="book_table.php">
        <label>Name: </label><input type="text" name="name" required><br>
        <label>Phone Number: </label><input type="text" name="phone_number" required><br>
        <label>Number of People: </label><input type="number" name="number_of_people" required><br>
        <label>Date: </label><input type="date" name="booking_date" required><br>
        <label>Time: </label><input type="time" name="booking_time" required><br>
        <button type="submit">Book</button>
    </form>
</body>
</html>
