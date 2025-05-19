<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "lms_db");

// Check for connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin/login_admin.html");
    exit();
}

// Fetch users
$result = $mysqli->query("SELECT id, username, role FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Management</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    .form-inline input, .form-inline select {
      padding: 5px;
      margin: 0;
    }

    .form-inline button {
      padding: 6px 12px;
    }
  </style>
</head>
<body>
  <header class="header">
    👤 Admin Panel - User Management
    <a href="../logout.php" class="btn" style="float:right; margin-right: 20px;">Logout</a>
  </header>

  <main class="main-section">
    <h2>User Management</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <form action="update_user.php" method="POST" class="form-inline">
              <td><?php echo $row['id']; ?></td>
              <td>
                <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
              </td>
              <td>
                <select name="role" required>
                  <option value="student" <?php if ($row['role'] === 'student') echo 'selected'; ?>>Student</option>
                  <option value="professor" <?php if ($row['role'] === 'professor') echo 'selected'; ?>>Professor</option>
                  <option value="admin" <?php if ($row['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                </select>
              </td>
              <td>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit">Update</button>
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
