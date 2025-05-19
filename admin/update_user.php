<?php
$mysqli = new mysqli("localhost", "root", "", "lms_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = $_POST['id'];
$username = $_POST['username'];
$role = $_POST['role'];

$stmt = $mysqli->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
$stmt->bind_param("ssi", $username, $role, $id);

if ($stmt->execute()) {
    header("Location: user_management.php");
} else {
    echo "Failed to update user.";
}
?>
