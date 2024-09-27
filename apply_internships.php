<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your DB username
$password = ""; // replace with your DB password
$dbname = "digital_solutions_cell"; // replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from the form
$title = $_POST['title'] ?? null;
$first_name = $_POST['first_name'] ?? null; // Corrected variable name
$last_name = $_POST['last_name'] ?? null; // Corrected variable name
$internship_role = $_POST['internship_role'] ?? null; // Corrected variable name
$college_name = $_POST['college_name'] ?? null; // Corrected variable name
// $recommendation = $_POST['recommendation'] ?? null; // Corrected variable name
$recommender_name = $_POST['recommender_name'] ?? null; // Corrected variable name
$recommender_designation = $_POST['recommender_designation'] ?? null; // Corrected variable name
$year_of_study = $_POST['year_of_study'] ?? null; // Corrected variable name
$internship_duration = $_POST['internship_duration'] ?? null; // Corrected variable name
$address = $_POST['address'] ?? null;
$zip_code = $_POST['zip_code'] ?? null; // Corrected variable name
$city = $_POST['city'] ?? null; // Changed from 'place' to 'city'
$state = $_POST['state'] ?? null;
$date_of_birth = $_POST['date_of_birth'] ?? null; // Corrected variable name
$country = $_POST['country'] ?? null;
$phone_number = $_POST['phone_number'] ?? null; // Corrected variable name
$email_address = $_POST['email_address'] ?? null; // Corrected variable name

// Handle file upload
if (isset($_FILES['letter_of_recommendation_path'])) { // Changed from 'recommendationLetter' to 'letter_of_recommendation_path'
    $letter_of_recommendation_path = $_FILES['letter_of_recommendation_path']['name'];
    $target_dir = "applicationsUpload/";
    $target_file = $target_dir . basename($letter_of_recommendation_path);
    move_uploaded_file($_FILES['letter_of_recommendation_path']['tmp_name'], $target_file);
}

// Prepare and bind, excluding the auto-incrementing id column

$stmt = $conn->prepare("INSERT INTO internship_applications (title, first_name, last_name, internship_role, college_name, recommender_name, recommender_designation, year_of_study, internship_duration, address, zip_code, city, state, date_of_birth, country, phone_number, email_address, letter_of_recommendation_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssssssss", $title, $first_name, $last_name, $internship_role, $college_name, $recommender_name, $recommender_designation, $year_of_study, $internship_duration, $address, $zip_code, $city, $state, $date_of_birth, $country, $phone_number, $email_address, $letter_of_recommendation_path);

// Execute and check for success
if ($stmt->execute()) {
    echo "Application submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>