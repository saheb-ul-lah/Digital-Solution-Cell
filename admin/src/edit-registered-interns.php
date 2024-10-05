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

// Handle GET request to fetch intern data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['internId'])) {
    $internId = $_GET['internId'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM internship_applications WHERE id = ?");
    $stmt->bind_param("s", $internId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the intern details
        $intern = $result->fetch_assoc();
        echo json_encode(['success' => true, 'intern' => $intern]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Intern not found.']);
    }

    // Close the statement
    $stmt->close();
    exit;
}

// Handle POST request to update intern data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $internId = $_POST['internId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $collegeName = $_POST['collegeName'];
    $internshipRole = $_POST['internshipRole'];
    $yearOfStudy = $_POST['yearOfStudy']; // Added yearOfStudy
    $teamNo = $_POST['teamNo']; // Added teamNo
    $recommenderName = $_POST['recommenderName']; // Added recommenderName
    $recommenderDesignation = $_POST['recommenderDesignation']; // Added recommenderDesignation
    $address = $_POST['address']; // Added address
    $zipCode = $_POST['zipCode']; // Added zipCode
    $city = $_POST['city']; // Added city
    $state = $_POST['state']; // Added state
    $country = $_POST['country']; // Added country
    $internshipDuration = $_POST['internshipDuration']; // Added internshipDuration
    $letterOfRecommendation = $_POST['letterOfRecommendation']; // Added letterOfRecommendation
    $dateOfBirth = $_POST['dateOfBirth']; // Added dateOfBirth

    // Prepare and execute the SQL update statement
    $stmt = $conn->prepare("UPDATE internship_applications SET 
        first_name = ?, 
        last_name = ?, 
        email_address = ?, 
        phone_number = ?, 
        college_name = ?, 
        internship_role = ?, 
        year_of_study = ?, 
        team_no = ?, 
        recommender_name = ?, 
        recommender_designation = ?, 
        address = ?, 
        zip_code = ?, 
        city = ?, 
        state = ?, 
        country = ?, 
        internship_duration = ?, 
        letter_of_recommendation_path = ?, 
        date_of_birth = ? 
        WHERE id = ?");

    $stmt->bind_param("ssssssssssssssssssi", 
        $firstName, 
        $lastName, 
        $email, 
        $phoneNumber, 
        $collegeName, 
        $internshipRole, 
        $yearOfStudy, 
        $teamNo, 
        $recommenderName, 
        $recommenderDesignation, 
        $address, 
        $zipCode, 
        $city, 
        $state, 
        $country, 
        $internshipDuration, 
        $letterOfRecommendation, 
        $dateOfBirth, 
        $internId);

    if ($stmt->execute()) {
        // On success, render the success page with transition message and redirect script
        echo '<div id="successMessage" class="success-banner">Intern details updated successfully!</div>';
        echo '<script>
                // Show success message for 1 second
                document.getElementById("successMessage").style.display = "block";
                setTimeout(function() {
                    document.getElementById("successMessage").classList.add("fade-out");
                    // After 1 second, redirect to registered-interns.html
                    setTimeout(function() {
                        window.location.href = "registered-interns.html";
                    }, 1000);
                }, 1000);
              </script>';
    } else {
        echo '<div id="errorMessage" class="error-banner">Failed to update intern details.</div>';
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
