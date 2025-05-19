<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "lms_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE username=? AND role='admin'");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}
?>
