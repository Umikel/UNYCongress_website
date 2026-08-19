<?php
require 'config.php';
// Retrieve data from AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $reference = $conn->real_escape_string($_POST['reference']);
    
    // Prepare and execute SQL statement to insert into `donation` table
    $sql = "INSERT INTO donation (first_name, last_name, email, amount, reference) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $first_name, $last_name, $email, $amount, $reference);
    
    if ($stmt->execute()) {
        echo "Success"; // Respond back to AJAX with success message
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>