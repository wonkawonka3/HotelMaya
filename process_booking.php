<?php
// Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $roomId = $_POST['room_id'];

    // Insert booking details
    $sql = "INSERT INTO bookings (name, email, phone, room_id, booking_date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phone, $roomId);

    if ($stmt->execute()) {
        // Update room status
        $updateRoomStatus = "UPDATE rooms SET status = 'Booked' WHERE id = ?";
        $stmtUpdate = $conn->prepare($updateRoomStatus);
        $stmtUpdate->bind_param("i", $roomId);
        $stmtUpdate->execute();

        // Send confirmation email
        $subject = "Booking Confirmation - Hotel Maya";
        $message = "
            <h1>Booking Confirmation</h1>
            <p>Dear $name,</p>
            <p>Thank you for booking with us. Here are your booking details:</p>
            <ul>
                <li>Room ID: $roomId</li>
                <li>Name: $name</li>
                <li>Email: $email</li>
                <li>Phone: $phone</li>
                <li>Booking Date: " . date('Y-m-d H:i:s') . "</li>
            </ul>
            <p>We look forward to hosting you!</p>
        ";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'carx41519@gmail.com';
            $mail->Password = 'vgyy wums kvlp moys';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@hotelmaya.com', 'Hotel Maya');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            echo "<p>Booking successful! A receipt has been sent to your email.</p>";
        } catch (Exception $e) {
            echo "<p>Booking successful, but email could not be sent. Error: {$mail->ErrorInfo}</p>";
        }
    } else {
        echo "<p>Error: Unable to process your booking.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
