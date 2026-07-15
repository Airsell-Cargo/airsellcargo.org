if (password_verify($password, $row['password'])) {
    $_SESSION['staff_id'] = $row['id'];
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $row['role'];

    // Update last login
    $update = $conn->prepare("UPDATE staff_users SET last_login = NOW() WHERE id = ?");
    $update->bind_param("i", $row['id']);
    $update->execute();
    $update->close();

    header("Location: dashboard.php");
    exit;
}
