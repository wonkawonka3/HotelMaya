<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_POST['username'], $_POST['password'])) {
    $_SESSION['error'] = "Please fill in both fields.";
    header("Location: login.php");
    exit;
}


$user = trim($_POST['username']);
$pass = trim($_POST['password']);


$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();


    if ($pass === $row['password']) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: add_room.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid password.";
        header("Location: UsersLogin.php");
        exit;
    }
} else {
    $_SESSION['error'] = "No user found with that username.";
    header("Location: UsersLogin.php");
    exit;
}

$conn->close();
?>
