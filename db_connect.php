<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mawb = $_POST['mawb'] ?? '';

    $stmt = $conn->prepare("SELECT status, origin, destination, updated_at 
                            FROM shipments WHERE mawb_number = ?");
    $stmt->bind_param("s", $mawb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h3>Shipment Status</h3>";
        echo "MAWB: " . htmlspecialchars($mawb) . "<br>";
        echo "Status: " . htmlspecialchars($row['status']) . "<br>";
        echo "Origin: " . htmlspecialchars($row['origin']) . "<br>";
        echo "Destination: " . htmlspecialchars($row['destination']) . "<br>";
        echo "Last Updated: " . htmlspecialchars($row['updated_at']) . "<br>";
    } else {
        echo "No shipment found for MAWB: " . htmlspecialchars($mawb);
    }

    $stmt->close();
}
$conn->close();
?>
