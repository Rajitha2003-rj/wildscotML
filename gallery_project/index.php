<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #faf3e0; /* Light beige background */
            margin: 0;
            padding: 20px;
            color: #4e342e; /* Dark brown text color */
        }

        h1 {
            text-align: center;
            color: #3e2723; /* Darker brown for the heading */
            margin-bottom: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff; /* White background for the container */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .top-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-buttons button {
            background-color: #6d4c41; /* Brown button background */
            color: #ffffff; /* White button text */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .top-buttons button:hover {
            background-color: #5d4037; /* Darker brown on hover */
        }

        .gallery-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .gallery-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            margin: 10px 0;
            padding: 15px;
            border: 2px solid #d7ccc8; /* Light brown border */
            background-color: #fff3e0; /* Very light brown background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .gallery-item img {
            max-width: 150px;
            height: auto;
            margin-right: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .operations {
            display: flex;
            flex-direction: column;
        }

        .operations button {
            background-color: #8d6e63; /* Lighter brown button background */
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px 0;
            transition: background-color 0.3s ease;
        }

        .operations button:hover {
            background-color: #6d4c41; /* Darker brown on hover */
        }

        .no-photos {
            color: #8d6e63;
            font-size: 18px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-buttons">
            <button onclick="window.location.href='gallery.php'">Client Side</button>
            <button onclick="window.location.href='upload.php'">Add Photo</button>
        </div>

        <h1>Maintain Gallery</h1>

        <div class="gallery-container">
            <?php
            // Connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gallery_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch photos from the database
            $sql = "SELECT id, photo_path FROM photos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output each photo
                while($row = $result->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<img src="' . $row["photo_path"] . '" alt="Photo">';
                    echo '<div class="operations">';
                    echo '<button onclick="deletePhoto(' . $row["id"] . ')">Delete</button>';
                    echo '<button onclick="updatePhoto(' . $row["id"] . ')">Update</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-photos">No photos available.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script>
        function deletePhoto(id) {
            if (confirm("Are you sure you want to delete this photo?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }

        function updatePhoto(id) {
            let newPhotoPath = prompt("Enter the new photo URL:");
            if (newPhotoPath) {
                fetch('update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id, photo: newPhotoPath })
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert("Photo updated successfully.");
                          window.location.reload(); // Refresh the page to show updated photo
                      } else {
                          alert("Error updating photo.");
                      }
                  });
            }
        }
    </script>
</body>
</html>
