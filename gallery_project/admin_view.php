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

// Fetch data from the database
$sql = "SELECT id, name, email, phone, location, wedding_date, message, submitted_at FROM inquiries";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Location</th><th>Wedding Date</th><th>Message</th><th>Submitted At</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        // Decrypt email and phone
        $encryption_key = 'your_secret_key'; // Same key as used for encryption
        $decrypted_email = openssl_decrypt(base64_decode($row['email']), 'aes-256-cbc', $encryption_key, 0, '1234567891011121');
        $decrypted_phone = openssl_decrypt(base64_decode($row['phone']), 'aes-256-cbc', $encryption_key, 0, '1234567891011121');
        
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $decrypted_email . "</td>";
        echo "<td>" . $decrypted_phone . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['wedding_date'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "<td>" . $row['submitted_at'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No inquiries found.";
}

$conn->close();
?>
