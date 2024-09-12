<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "photographer_inquiries";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$wedding_date = $_POST['wedding_date'];
$message = $_POST['message'];

// Encrypt email and phone
$encryption_key = 'your_secret_key'; // Use a secure key
$encrypted_email = base64_encode(openssl_encrypt($email, 'aes-256-cbc', $encryption_key, 0, '1234567891011121'));
$encrypted_phone = base64_encode(openssl_encrypt($phone, 'aes-256-cbc', $encryption_key, 0, '1234567891011121'));

// Insert data into the database
$sql = "INSERT INTO inquiries (name, email, phone, location, wedding_date, message) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $encrypted_email, $encrypted_phone, $location, $wedding_date, $message);

if ($stmt->execute()) {
    echo "Request sent successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
