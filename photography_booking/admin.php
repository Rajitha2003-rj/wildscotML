<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Inquiries</title>
    <style>
        body {
            background-color: #f7f3ef;
            font-family: Arial, sans-serif;
        }

        .admin-panel {
            background-color: #ffffff;
            padding: 20px;
            max-width: 800px;
            margin: 50px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-panel h2 {
            text-align: center;
            color: #5d4037;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #b0a093;
        }

        th, td {
            padding: 12px;
            text-align: left;
            color: #5d4037;
        }

        th {
            background-color: #e0d8d3;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="admin-panel">
        <h2>View Inquiries</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Location</th>
                <th>Date</th>
                <th>Message</th>
            </tr>
            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'photography_booking');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Decrypt function
            function decryptData($data) {
                $encryption_key = 'your_secret_key_here';
                $decoded_data = base64_decode($data);

                // Ensure the string has the delimiter
                if (strpos($decoded_data, '::') !== false) {
                    list($encrypted_data, $iv) = explode('::', $decoded_data, 2);
                    return openssl_decrypt($encrypted_data, 'aes-128-cbc', $encryption_key, 0, $iv);
                } else {
                    // Return a default message if decryption fails or the format is invalid
                    return 'Decryption failed';
                }
            }

            // Fetch inquiries
            $result = $conn->query("SELECT * FROM inquiries");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>" . decryptData($row['email']) . "</td>
                        <td>" . decryptData($row['phone']) . "</td>
                        <td>{$row['location']}</td>
                        <td>{$row['wedding_date']}</td>
                        <td>{$row['message']}</td>
                      </tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>
