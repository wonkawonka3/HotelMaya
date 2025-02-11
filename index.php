<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM rooms WHERE status = 'Available'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System - Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="header">
    <div class="container">
        <h1>Hotel Maya</h1>
        <p>Your comfort is our priority. Book a room today!</p>
    </div>
</header>

<section id="about">
    <div class="container">
        <h2>About Our Hotel</h2>
        <p>Our hotel offers a variety of rooms to cater to all needs, whether you're here for business, leisure, or a special occasion. Enjoy a comfortable and relaxing stay with excellent amenities.</p>
    </div>
</section>

<section id="rooms">
    <div class="container">
        <h2>Available Rooms</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['room_number'] ?></td>
                        <td><?= $row['room_type'] ?></td>
                        <td><a href="book_room.php?id=<?= $row['id'] ?>"><button class="btn btn-primary">Book Now</button></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<section id="services">
    <div class="container">
        <h2>Our Services</h2>
        <div class="row">
            <div class="col-md-4 service">
                <img src="sample lang1.webp" alt="Room Service">
                <h3>Room Service</h3>
                <p>Enjoy delicious meals and snacks in the comfort of your room.</p>
            </div>
            <div class="col-md-4 service">
                <img src="sample 2.jpg" alt="Spa">
                <h3>Spa</h3>
                <p>Relax and rejuvenate with our spa treatments and massages.</p>
            </div>
            <div class="col-md-4 service">
                <img src="sample 3.jpeg" alt="Swimming Pool">
                <h3>Swimming Pool</h3>
                <p>Take a dip in our pool and enjoy the sun.</p>
            </div>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, feel free to reach out!</p>
        <form action="send_message.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn btn-success">Send Message</button>
        </form>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2025 Hotel Management System. All rights reserved.</p>
        <p>Are you an admin? Sign in to modify rooms:</p>
        <a href="UsersLogin.php"><button class="btn btn-secondary">Admin Login</button></a>
    </div>
</footer>

</body>
</html>

<?php $conn->close(); ?>
