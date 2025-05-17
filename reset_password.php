<?php
$mysqli = new mysqli("localhost", "root", "", "lms_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $new_password, $username);

if ($stmt->execute()) {
    echo "Password updated successfully. <a href='index.html'>Go back to login</a>";
} else {
    echo "Error updating password.";
}
?>
