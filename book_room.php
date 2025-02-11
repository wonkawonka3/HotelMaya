<?php
$roomId = $_GET['id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Book Room</h1>
        <form action="process_booking.php" method="POST">
            <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
