<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd10 URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">DepEd10 URL Shortener</h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $long_url = trim($_POST['long_url']);
                            $custom_code = trim($_POST['custom_code']);

                            // If no custom code, generate one
                            if (empty($custom_code)) {
                                $short_code = substr(md5(time() . $long_url), 0, 6);
                            } else {
                                $short_code = substr(preg_replace('/[^A-Za-z0-9_-]/', '', $custom_code), 0, 20);

                                // Check if custom code is already taken
                                $check = $conn->prepare("SELECT id FROM short_links WHERE short_code = ?");
                                $check->bind_param("s", $short_code);
                                $check->execute();
                                $check->store_result();

                                if ($check->num_rows > 0) {
                                    echo '<div class="alert alert-danger text-center">❌ Custom link already taken. Please choose another.</div>';
                                    $check->close();
                                    exit;
                                }
                                $check->close();
                            }

                            // Save to DB
                            $stmt = $conn->prepare("INSERT INTO short_links (long_url, short_code) VALUES (?, ?)");
                            $stmt->bind_param("ss", $long_url, $short_code);
                            $stmt->execute();

                            $short_link = "https://deped10.com/s/" . $short_code;
                            echo '<div class="alert alert-success text-center">
                                    <strong>Short Link:</strong> 
                                    <a href="'.$short_link.'" target="_blank">'.$short_link.'</a>
                                  </div>';
                        }
                        ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="long_url" class="form-label">Enter Long URL</label>
                                <input type="url" name="long_url" id="long_url" class="form-control" placeholder="https://example.com/very/long/link" required>
                            </div>

                            <div class="mb-3">
                                <label for="custom_code" class="form-label">Custom Short Link (Optional)</label>
                                <input type="text" name="custom_code" id="custom_code" class="form-control" maxlength="20" placeholder="my-custom-text">
                                <small class="text-muted">Only letters, numbers, dash (-) and underscore (_) allowed. Max 20 characters.</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Shorten Link</button>
                            </div>
                        </form>

                    </div>
                    <div class="card-footer text-center text-muted small">
                        &copy; <?php echo date("Y"); ?> DepEd Region 10
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
