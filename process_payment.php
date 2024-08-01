<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty for root user)
$dbname = "komatha_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define a function to sanitize user input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $package = isset($_POST['package']) ? sanitizeInput($_POST['package']) : '';
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $address = isset($_POST['address']) ? sanitizeInput($_POST['address']) : '';
    $paymentMethod = isset($_POST['payment_method']) ? sanitizeInput($_POST['payment_method']) : '';

    // Initialize variables for payment details
    $cardNumber = '';
    $expiryDate = '';
    $cvv = '';
    $upiId = '';
    $qrCode = '';

    // Check and sanitize payment details based on the selected method
    if ($paymentMethod === 'credit_card') {
        $cardNumber = isset($_POST['card_number']) ? sanitizeInput($_POST['card_number']) : '';
        $expiryDate = isset($_POST['expiry_date']) ? sanitizeInput($_POST['expiry_date']) : '';
        $cvv = isset($_POST['cvv']) ? sanitizeInput($_POST['cvv']) : '';
    } elseif ($paymentMethod === 'upi') {
        $upiId = isset($_POST['upi_id']) ? sanitizeInput($_POST['upi_id']) : '';
    } elseif ($paymentMethod === 'qr_code') {
        $qrCode = isset($_POST['qr_code']) ? sanitizeInput($_POST['qr_code']) : '';
    }

    // Basic validation
    if (empty($package) || empty($name) || empty($email) || empty($address) || empty($paymentMethod)) {
        die("Please fill in all required fields.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO payments (package, name, email, address, payment_method, card_number, expiry_date, cvv, upi_id, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $package, $name, $email, $address, $paymentMethod, $cardNumber, $expiryDate, $cvv, $upiId, $qrCode);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Payment details recorded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
