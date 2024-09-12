<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Photographer</title>
    <style>
        body {
            background-color: #f7f3ef;
            font-family: Arial, sans-serif;
        }

        .contact-form {
            background-color: #ffffff;
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-form h2 {
            text-align: center;
            color: #5d4037;
        }

        .contact-form p {
            text-align: center;
            color: #7b6c61;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form input[type="date"],
        .contact-form textarea {
            width: 96%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #b0a093;
            border-radius: 5px;
            background-color: #e0d8d3;
            color: #5d4037;
        }

        .contact-form input[type="text"]::placeholder,
        .contact-form input[type="email"]::placeholder,
        .contact-form textarea::placeholder {
            color: #7b6c61;
        }

        .contact-form button {
            width: 100%;
            padding: 15px;
            background-color: #5d4037;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-form button:hover {
            background-color: #4b342e;
        }

        .notification {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="contact-form">
        <h2>Book a Photographer</h2>
        <p>Fill out the form below to inquire about booking a session.</p>

        <div id="notification" class="notification"></div>

        <form id="contactForm" action="submit_inquiry.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="phone" placeholder="Your Phone" required>
            <input type="text" name="location" placeholder="Location of Wedding" required>
            <input type="date" name="wedding_date" placeholder="Date of Wedding" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Create a new FormData object to send form data via fetch
            const formData = new FormData(this);

            fetch('submit_inquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Get the response as text
            .then(result => {
                let notification = document.getElementById('notification');
                if (result.trim() === 'success') {
                    notification.className = 'notification success';
                    notification.textContent = 'Your message has been sent successfully!';
                } else {
                    notification.className = 'notification error';
                    notification.textContent = 'There was an error sending your message. Please try again later.';
                }
              notification.style.display = 'block';
            })
            .catch(error => {
                let notification = document.getElementById('notification');
                notification.className = 'notification error';
                notification.textContent = 'There was an error sending your message. Please try again later.';
                notification.style.display = 'block';
            });
        });
    </script>
</body>

</html>
