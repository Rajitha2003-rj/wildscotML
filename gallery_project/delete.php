<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$photoId = $_GET['id'];
$sql = "DELETE FROM photos WHERE id=$photoId";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
