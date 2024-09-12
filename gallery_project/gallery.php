<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        /* Body and Font Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #7b6c61; /* Darker background color */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #5d4037; /* Dark brown color */
            padding: 20px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 40px;
            text-align: center;
            font-weight: bold;
        }

        .sidebar button {
            background-color: #7b6c61; /* Matches body background */
            color: #ffffff;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: left;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .sidebar button:hover {
            background-color: #4b342e;
        }

        .sidebar .client-button {
            background-color: #ffffff;
            color: #5d4037;
            margin-top: auto;
            font-weight: bold;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content iframe {
            width: 100%;
            height: calc(100vh - 40px);
            border: none;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #f9e5ab; /* Light beige */
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .navbar a,
        .navbar button {
            margin: 0 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
        }

        .navbar a:hover,
        .navbar button:hover {
            color: #7b6c61;
        }

        /* Gallery Container Styles */
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 20px;
        }

        .gallery-item {
            flex-basis: calc(33.333% - 30px); /* 3 items per row with a 15px gap */
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        /* Responsive Gallery Adjustments */
        @media (max-width: 768px) {
            .gallery-item {
                flex-basis: calc(50% - 30px); /* 2 items per row on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .gallery-item {
                flex-basis: calc(100% - 30px); /* 1 item per row on very small screens */
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="filter-btn" data-filter="all">ALL</a>
        <a href="#" class="filter-btn" data-filter="nature">NATURE</a>
        <a href="#" class="filter-btn" data-filter="weddings">WEDDINGS</a>
        <a href="#" class="filter-btn" data-filter="events">OTHER EVENTS</a>
        <a href="#" class="filter-btn" data-filter="portraits">PORTRAITS</a>
    </div>

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
        $sql = "SELECT photo_path FROM photos";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
    // Output each photo
    while ($row = $result->fetch_assoc()) {
        echo '<div class="gallery-item ' . htmlspecialchars($row["photo_path"], ENT_QUOTES, 'UTF-8') . '">';
        echo '<img src="' . htmlspecialchars($row["photo_path"], ENT_QUOTES, 'UTF-8') . '" alt="Photo">';
        echo '</div>';
    }
} else {
    echo "No photos available.";
}

        $conn->close();
        ?>
    </div>

    <script>
        // JavaScript for filtering images by category
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
