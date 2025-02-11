<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];


    $check_room = "SELECT * FROM rooms WHERE room_number = ?";
    $stmt = $conn->prepare($check_room);
    $stmt->bind_param("s", $room_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
  
        echo "<script>alert('Room number already exists. Please use a different room number.');</script>";
    } else {
 
        $insert_room = "INSERT INTO rooms (room_number, room_type, status) 
                        VALUES (?, ?, 'available')";
        $stmt = $conn->prepare($insert_room);
        $stmt->bind_param("ss", $room_number, $room_type);

        if ($stmt->execute()) {
            header("Location: successfull.html");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<header>
    <h1>Hotel Management System</h1>
    <p>Admin Panel - Add New Room</p>
</header>

<div class="container">
    <h2>Add New Room</h2>
    <form method="POST">
        <label for="room_number">Room Number:</label>
        <input type="text" name="room_number" required>

        <label for="room_type">Room Type:</label>
        <input type="text" name="room_type" required>

        <button type="submit">Add Room</button>
        <button type="button" onclick="window.location.href='logout.php'">Logout</button>
    </form>
</div>

</body>
</html>
