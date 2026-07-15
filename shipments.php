<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// Handle search
$search = $_GET['mawb'] ?? '';
$sql = "SELECT mawb_number, status, origin, destination, updated_at 
        FROM shipments";
if (!empty($search)) {
    $sql .= " WHERE mawb_number LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$search%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Airsell Cargo - Shipments</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; }
    header { background: #d32f2f; color: #fff; padding: 15px; text-align: center; }
    .container { padding: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #d32f2f; color: #fff; }
    .search-box { margin-bottom: 20px; text-align: center; }
    .search-box input { padding: 8px; width: 250px; }
    .search-box button { padding: 8px 16px; background: #d32f2f; color: #fff; border: none; border-radius: 4px; }
    .search-box button:hover { background: #b71c1c; }
  </style>
</head>
<body>
  <header>
    <h1>Shipments</h1>
    <a href="dashboard.php" style="color:#fff; text-decoration:none;">← Back to Dashboard</a>
  </header>
  <div class="container">
    <div class="search-box">
      <form method="GET" action="shipments.php">
        <input type="text" name="mawb" placeholder="Search by MAWB number" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
      </form>
    </div>
    <table>
      <tr>
        <th>MAWB Number</th>
        <th>Status</th>
        <th>Origin</th>
        <th>Destination</th>
        <th>Last Updated</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['mawb_number']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['origin']); ?></td>
            <td><?php echo htmlspecialchars($row['destination']); ?></td>
            <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No shipments found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
<?php
if (isset($stmt)) $stmt->close();
$conn->close();
?>
