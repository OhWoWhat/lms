<?php
session_start();

// Ensure only students can access
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login_student.html");
    exit();
}

$username = $_SESSION['username'];

// Database connection
$mysqli = new mysqli("localhost", "root", "", "lms_db");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch enrolled courses for the student
$stmt = $mysqli->prepare("SELECT c.course_name, c.description 
                          FROM courses c 
                          JOIN enrollments e ON c.course_id = e.course_id 
                          JOIN users u ON e.user_id = u.id 
                          WHERE u.username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Courses</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <header class="header">
    📘 LMS Portal - My Courses
    <a href="dashboard.php" class="btn" style="float:right; margin-right: 20px;">Back to Dashboard</a>
  </header>

  <main class="main-section">
    <h2>Enrolled Courses</h2>

    <?php if (count($courses) > 0): ?>
      <div class="card-grid">
        <?php foreach ($courses as $course): ?>
          <div class="card">
            <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
            <p><?php echo htmlspecialchars($course['description']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>You are not enrolled in any courses yet.</p>
    <?php endif; ?>
  </main>

  <footer class="footer">
    &copy; 2025 LMS Portal. All rights reserved.
  </footer>
</body>
</html>
