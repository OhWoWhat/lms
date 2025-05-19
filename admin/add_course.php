<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.html");
    exit();
}

// DB connection
$mysqli = new mysqli("localhost", "root", "", "lms_db");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$message = "";

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name']);
    $description = trim($_POST['description']);

    $stmt = $mysqli->prepare("INSERT INTO courses (course_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $course_name, $description);

    if ($stmt->execute()) {
        $message = "✅ Course added successfully.";
        $logStmt = $mysqli->prepare("INSERT INTO logs (username, role, action) VALUES (?, ?, ?)");
        $logAction = "Admin added a new course: $course_name";
        $logStmt->bind_param("sss", $_SESSION['username'], $_SESSION['role'], $logAction);
        $logStmt->execute();
    } else {
        $message = "❌ Failed to add course.";
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $deleteStmt = $mysqli->prepare("DELETE FROM courses WHERE course_id = ?");
    $deleteStmt->bind_param("i", $delete_id);
    if ($deleteStmt->execute()) {
        $message = "🗑️ Course deleted.";
        $logAction = "Admin deleted course ID: $delete_id";
        $logStmt = $mysqli->prepare("INSERT INTO logs (username, role, action) VALUES (?, ?, ?)");
        $logStmt->bind_param("sss", $_SESSION['username'], $_SESSION['role'], $logAction);
        $logStmt->execute();
    }
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
    $course_id = (int)$_POST['course_id'];
    $new_name = trim($_POST['course_name']);
    $new_desc = trim($_POST['description']);

    $updateStmt = $mysqli->prepare("UPDATE courses SET course_name = ?, description = ? WHERE course_id = ?");
    $updateStmt->bind_param("ssi", $new_name, $new_desc, $course_id);

    if ($updateStmt->execute()) {
        $message = "✏️ Course updated.";
        $logAction = "Admin updated course ID $course_id to: $new_name";
        $logStmt = $mysqli->prepare("INSERT INTO logs (username, role, action) VALUES (?, ?, ?)");
        $logStmt->bind_param("sss", $_SESSION['username'], $_SESSION['role'], $logAction);
        $logStmt->execute();
    }
}

// Fetch all courses
$courses = $mysqli->query("SELECT * FROM courses ORDER BY course_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Courses</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    table {
      width: 100%;
      margin-top: 30px;
      border-collapse: collapse;
      background-color: white;
    }
    th, td {
      padding: 10px 14px;
      border: 1px solid #ccc;
      text-align: left;
    }
    th {
      background-color: #4CAF50;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .action-btn {
      padding: 6px 10px;
      margin-right: 4px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .edit-btn { background-color: #2196F3; color: white; }
    .delete-btn { background-color: #f44336; color: white; }
  </style>
</head>
<body>
  <header class="header">
    📘 Admin Panel - Manage Courses
    <a href="../logout.php" class="btn" style="float:right; margin-right: 20px;">Logout</a>
  </header>

  <main class="main-section">
    <h2>Add New Course</h2>

    <?php if ($message): ?>
      <p style="color: green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="course_name" placeholder="Course Name" required>
      <textarea name="description" placeholder="Course Description" required></textarea>
      <button type="submit" name="add_course">Add Course</button>
    </form>

    <h2 style="margin-top: 40px;">Existing Courses</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Course Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($course = $courses->fetch_assoc()): ?>
          <tr>
            <form method="POST" action="">
              <td><?= $course['course_id'] ?>
                <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
              </td>
              <td>
                <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>
              </td>
              <td>
                <input type="text" name="description" value="<?= htmlspecialchars($course['description']) ?>" required>
              </td>
              <td>
                <button type="submit" name="edit_course" class="action-btn edit-btn">Save</button>
                <a href="?delete_id=<?= $course['course_id'] ?>" onclick="return confirm('Are you sure you want to delete this course?');" class="action-btn delete-btn">Delete</a>
              </td>
            </form>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>

  <footer class="footer">
    &copy; 2025 LMS Portal. All rights reserved.
  </footer>
</body>
</html>
