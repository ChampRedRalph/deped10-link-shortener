<?php
include '../db.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';

if ($code) {
    $stmt = $conn->prepare("SELECT id, long_url FROM short_links WHERE short_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Increment click count
        $update = $conn->prepare("UPDATE short_links SET clicks = clicks + 1 WHERE id = ?");
        $update->bind_param("i", $row['id']);
        $update->execute();

        header("Location: " . $row['long_url']);
        exit();
    }
}

echo "Invalid or expired link.";
?>
