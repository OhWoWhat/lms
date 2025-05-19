<?php
session_start();

// Check login and role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login_student.html");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Assignments</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <header class="header">
    📚 LMS Portal - Assignments
    <a href="dashboard.php" class="btn" style="float:right; margin-right: 20px;">Back to Dashboard</a>
  </header>

  <main class="main-section">
    <h2>My Assignments</h2>

    <div class="card-grid">
      <div class="card">
        <h3>Assignment 1: Intro to PHP</h3>
        <p>Due Date: May 25, 2025</p>
        <p>Status: <strong>Pending</strong></p>
      </div>

      <div class="card">
        <h3>Assignment 2: Database Connection</h3>
        <p>Due Date: May 28, 2025</p>
        <p>Status: <strong>Submitted</strong></p>
      </div>

      <div class="card">
        <h3>Assignment 3: Build a Login System</h3>
        <p>Due Date: June 1, 2025</p>
        <p>Status: <strong>Not Started</strong></p>
      </div>
    </div>
  </main>

  <footer class="footer">
    &copy; 2025 LMS Portal. All rights reserved.
  </footer>
</body>
</html>
