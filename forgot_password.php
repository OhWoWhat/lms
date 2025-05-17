<?php
$mysqli = new mysqli("localhost", "root", "", "lms_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">🔐 LMS Portal - Reset Password</header>

  <main class="login-page">
    <div class="login-box">
      <?php
      if ($result->num_rows > 0) {
          echo "<h2>Reset Your Password</h2>";
          echo "<form action='reset_password.php' method='POST'>
                  <input type='hidden' name='username' value='" . htmlspecialchars($username) . "'>
                  <input type='password' name='new_password' placeholder='Enter new password' required>
                  <button type='submit'>Update Password</button>
                </form>";
      } else {
          echo "<h2>User Not Found</h2>";
          echo "<p>The username <strong>" . htmlspecialchars($username) . "</strong> does not exist.</p>";
          echo "<a href='forgot_password.html' class='btn'>Try Again</a>";
      }
      ?>
    </div>
  </main>

  <footer class="footer">
    &copy; 2025 LMS Portal. All rights reserved.
  </footer>
</body>
</html>
