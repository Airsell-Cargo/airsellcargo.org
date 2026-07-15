<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// Fetch counts
$shipments_count = $conn->query("SELECT COUNT(*) AS total FROM shipments")->fetch_assoc()['total'];
$manifests_count = $conn->query("SELECT COUNT(*) AS total FROM manifests")->fetch_assoc()['total'];
$pending_requests = $conn->query("SELECT COUNT(*) AS total FROM contact_form WHERE status IS NULL")->fetch_assoc()['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Airsell Cargo - Staff Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; }
    header { background: #d32f2f; color: #fff; padding: 15px; text-align: center; position: relative; }
    .container { padding: 30px; display: flex; flex-wrap: wrap; justify-content: center; }
    .card {
      background: #fff; border-radius: 8px; padding: 20px; margin: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 250px; text-align: center;
    }
    h2 { margin: 0; color: #333; }
    .logout { position: absolute; top: 15px; right: 20px; }
    .logout a { color: #fff; text-decoration: none; }
    .nav-links { margin-top: 40px; text-align: center; }
    .nav-links a {
      display: inline-block; margin: 10px; padding: 12px 24px;
      background: #d32f2f; color: #fff; text-decoration: none; border-radius: 4px;
    }
    .nav-links a:hover { background: #b71c1c; }
  </style>
</head>
<body>
  <header>
    <h1>Staff Dashboard</h1>
    <div class="logout"><a href="logout.php">Logout</a></div>
  </header>
  <div class="container">
    <div class="card">
      <h2><?php echo $shipments_count; ?></h2>
      <p>Total Shipments</p>
    </div>
    <div class="card">
      <h2><?php echo $manifests_count; ?></h2>
      <p>Total Manifests</p>
    </div>
    <div class="card">
      <h2><?php echo $pending_requests; ?></h2>
      <p>Pending Client Requests</p>
    </div>
  </div>
  <div class="nav-links">
    <a href="shipments.php">View Shipments</a>
    <a href="manifests.php">View Manifests</a>
    <a href="requests.php">Manage Client Requests</a>
  </div>
</body>
</html>
