<?php
session_start();
include 'db_connect.php';

// Optional: restrict access so only logged-in admins can register staff
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'] ?? 'staff';

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into staff_users table
    $stmt = $conn->prepare("INSERT INTO staff_users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<p>Staff account created successfully for <strong>" . htmlspecialchars($username) . "</strong>.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Staff - Airsell Cargo</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background:#f8f9fa; padding:40px; }
    form { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
    input, select { width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:4px; }
    button { background:#d32f2f; color:#fff; padding:10px 20px; border:none; border-radius:4px; cursor:pointer; }
    button:hover { background:#b71c1c; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Register New Staff</h2>
  <form method="POST" action="register_staff.php">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>Role:</label>
    <select name="role">
      <option value="staff">Staff</option>
      <option value="admin">Admin</option>
    </select>

    <button type="submit">Create Account</button>
  </form>
</body>
</html>
