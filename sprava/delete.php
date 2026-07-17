<?php
require_once(__DIR__ . "/../connection.php");
require_once(__DIR__ . "/validation.php");

if (empty($_SESSION["authenticated"])) {
    http_response_code(403);
    die("Forbidden");
}

if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];

    $stmt = $db->prepare("SELECT link FROM video WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $link = "";
    if ($row = $result->fetch_assoc()) {
        $link = $row["link"];
    }

    if ($link !== "") {
        $videoPath = __DIR__ . "/../video/" . basename($link);
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }
    }

    $del = $db->prepare("DELETE FROM video WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();

    echo "Video úspešne zmazané.";
} else {
    echo "Nezmazané";
}
?>
<a href="index.php">Späť</a>
