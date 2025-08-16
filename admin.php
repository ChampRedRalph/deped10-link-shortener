<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Delete link if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM short_links WHERE id = $id");
    header("Location: admin.php");
    exit();
}

// Fetch all links
$links = $conn->query("SELECT * FROM short_links ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h3 class="mb-4">📊 DepEd10 URL Shortener - Admin Dashboard</h3>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Short Code</th>
                    <th>Original URL</th>
                    <th>Clicks</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $links->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><a href="https://deped10.com/s/<?= $row['short_code'] ?>" target="_blank"><?= $row['short_code'] ?></a></td>
                    <td><?= htmlspecialchars($row['long_url']) ?></td>
                    <td><?= $row['clicks'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this link?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>
