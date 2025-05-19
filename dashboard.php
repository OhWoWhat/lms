<?php
session_start();

// Fake login check – replace this with your real login logic
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login_student.html");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LMS Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    📚 LMS Portal - Welcome, <?php echo htmlspecialchars($username); ?>!
    <a href="logout.php" class="btn" style="float:right; margin-right: 20px;">Logout</a>
  </header>

  <main class="main-section">
    <h2>Dashboard</h2>

    <?php if ($role === 'student'): ?>
    <div class="card-grid">
      <a href="student/student_courses.php" class="card">
        <h3>My Courses</h3>
        <p>View and manage your enrolled courses.</p>
      </a>
      <a href="student/assignments.php" class="card">
        <h3>Assignments</h3>
        <p>Check upcoming and submitted assignments.</p>
      </a>
    </div>
    <?php elseif ($role === 'professor'): ?>
      <div class="card-grid">
        <div class="card">
          <h3>Manage Courses</h3>
          <p>Create and update your course content.</p>
        </div>
        <div class="card">
          <h3>Grade Submissions</h3>
          <p>Evaluate student work and provide feedback.</p>
        </div>
      </div>
    <?php elseif ($role === 'admin'): ?>
      <div class="card-grid">
        <a href="admin/user_management.php" class="card">
          <h3>User Management</h3>
          <p>Add, remove, or update users in the system.</p>
        </a>
        <a href="admin/system_logs.php" class="card">
          <h3>System Logs</h3>
          <p>Monitor activity and usage statistics.</p>
        </a>
        <a href="admin/add_course.php" class="card">
          <h3>Add Course</h3>
          <p>Add a new course to the system.</p>
        </a>
      </div>
    <?php endif; ?>
  </main>

  <footer class="footer">
    &copy; 2025 LMS Portal. All rights reserved.
  </footer>
</body>
</html>
