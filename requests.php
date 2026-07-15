<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
    $new_status = $_POST['status'] ?? 'pending';

    $stmt = $conn->prepare("UPDATE contact_form SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $request_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch client requests
$sql = "SELECT id, name, email, phone, service_type, subject, details, submitted_at, status 
        FROM contact_form ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Airsell Cargo - Client Requests</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; }
    header { background: #d32f2f; color: #fff; padding: 15px; text-align: center; }
    .container { padding: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #d32f2f; color: #fff; }
    .back-link { color:#fff; text-decoration:none; }
    .status-pending { color: #d32f2f; font-weight: bold; }
    .status-done { color: green; font-weight: bold; }
    form { display:inline; }
    button { padding: 4px 8px; border:none; border-radius:4px; cursor:pointer; }
    .btn-done { background: green; color:#fff; }
    .btn-pending { background: #d32f2f; color:#fff; }
  </style>
</head>
<body>
  <header>
    <h1>Client Requests</h1>
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
  </header>
  <div class="container">
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Service Type</th>
        <th>Subject</th>
        <th>Details</th>
        <th>Submitted At</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['service_type']); ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo htmlspecialchars($row['details']); ?></td>
            <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
            <td class="<?php echo $row['status'] === 'done' ? 'status-done' : 'status-pending'; ?>">
              <?php echo $row['status'] ?? 'Pending'; ?>
            </td>
            <td>
              <form method="POST" action="requests.php">
                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="status" value="done">
                <button type="submit" class="btn-done">Mark Done</button>
              </form>
              <form method="POST" action="requests.php">
                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="status" value="pending">
                <button type="submit" class="btn-pending">Mark Pending</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="10">No client requests found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
<?php
$conn->close();
?>
