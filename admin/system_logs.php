<?php
// Fetch logs
$mysqli = new mysqli("localhost", "root", "", "lms_db");
$logsResult = $mysqli->query("SELECT * FROM logs ORDER BY timestamp DESC");
?>

<style>
  .log-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
  }

  .log-table th, .log-table td {
    padding: 12px 16px;
    text-align: left;
  }

  .log-table thead {
    background-color: #4CAF50;
    color: white;
  }

  .log-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .log-table tbody tr:hover {
    background-color: #f1f1f1;
  }

  .log-table th {
    font-weight: bold;
    border-bottom: 2px solid #ddd;
  }
</style>

<table class="log-table">
  <thead>
    <tr>
      <th>🕒 Timestamp</th>
      <th>👤 Username</th>
      <th>🧑‍💼 Role</th>
      <th>📝 Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($log = $logsResult->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($log['timestamp']) ?></td>
        <td><?= htmlspecialchars($log['username']) ?></td>
        <td><?= htmlspecialchars($log['role']) ?></td>
        <td><?= htmlspecialchars($log['action']) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
