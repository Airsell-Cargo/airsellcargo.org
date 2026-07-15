<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// Fetch manifests
$sql = "SELECT manifest_id, shipment_count, created_at 
        FROM manifests ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Airsell Cargo - Manifests</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; }
    header { background: #d32f2f; color: #fff; padding: 15px; text-align: center; }
    .container { padding: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #d32f2f; color: #fff; }
    .back-link { color:#fff; text-decoration:none; }
  </style>
</head>
<body>
  <header>
    <h1>Manifests</h1>
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
  </header>
  <div class="container">
    <table>
      <tr>
        <th>Manifest ID</th>
        <th>Shipment Count</th>
        <th>Created At</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['manifest_id']); ?></td>
            <td><?php echo htmlspecialchars($row['shipment_count']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="3">No manifests found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
<?php
$conn->close();
?>
