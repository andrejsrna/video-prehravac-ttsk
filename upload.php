<?php
require_once("connection.php");
require_once("validation.php");
session_start();

$msg = "";

if (empty($_SESSION["authenticated"])) {
    http_response_code(403);
    die("Forbidden");
}

if (isset($_POST['upload']) && isset($_FILES['video'])) {
    $original = $_FILES['video']['name'] ?? '';
    $uploadError = $_FILES['video']['error'] ?? UPLOAD_ERR_NO_FILE;

    $allowedExtensions = ['mp4', 'm4v', 'webm', 'mov'];
    $allowedMimeTypes = ['video/mp4', 'video/x-m4v', 'video/webm', 'video/quicktime'];

    if ($uploadError !== UPLOAD_ERR_OK || $original === '') {
        $msg = "Nahrávanie zlyhalo";
    } else {
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $mime = mime_content_type($_FILES['video']['tmp_name']);

        if (!in_array($ext, $allowedExtensions, true) || !in_array($mime, $allowedMimeTypes, true)) {
            $msg = "Nepovolený typ súboru. Povolené prípony: " . implode(', ', $allowedExtensions);
        } else {
            $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($original));
            $safeName = time() . '_' . $safeName;
            $targetDir = __DIR__ . "/video/";
            $target = $targetDir . $safeName;

            if (move_uploaded_file($_FILES['video']['tmp_name'], $target)) {
                $stmt = $db->prepare("INSERT INTO video (link) VALUES (?)");
                $stmt->bind_param("s", $safeName);
                $stmt->execute();
                $msg = "Video úspešne nahrané";
            } else {
                $msg = "Nahrávanie zlyhalo";
            }
        }
    }
} else {
    $msg = "Nahrávanie zlyhalo";
}
?>
<a href="index.php">Späť</a>
<?php echo htmlspecialchars($msg); ?>
