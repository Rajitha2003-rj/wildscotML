<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "photography_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Encrypt function
function encryptData($data) {
    $encryption_key = 'your_secret_key_here'; // Must be 16 bytes long
    $iv = openssl_random_pseudo_bytes(16); // 16-byte IV for AES-128-CBC
    $encrypted = openssl_encrypt($data, 'aes-128-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv); // Encode both encrypted data and IV
}

// Get form data and encrypt phone and email
$name = $_POST['name'];
$email = encryptData($_POST['email']);
$phone = encryptData($_POST['phone']);
$location = $_POST['location'];
$wedding_date = $_POST['wedding_date'];
$message = $_POST['message'];

// Insert data into the database
$sql = "INSERT INTO inquiries (name, email, phone, location, wedding_date, message) 
        VALUES ('$name', '$email', '$phone', '$location', '$wedding_date', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "success"; // Make sure only 'success' is echoed on successful submission
} else {
    echo "error"; // Return 'error' if the query fails
}

// Close the connection
$conn->close();
?>
