<?php
include 'db_connect.php'; // central connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form inputs safely
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $service = $_POST['service-type'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $details = $_POST['feedback'] ?? '';

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact_form 
        (name, email, phone, service_type, subject, details) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $service, $subject, $details);

    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: thankyou.html"); 
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
