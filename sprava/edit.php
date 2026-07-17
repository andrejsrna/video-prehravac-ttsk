<?php
require_once(__DIR__ . "/../connection.php");
require_once(__DIR__ . "/validation.php");

if (empty($_SESSION["authenticated"])) {
    http_response_code(403);
    die("Forbidden");
}

$msg = "";
$id = (int) ($_POST["id"] ?? 0);
$value = isset($_POST["noplay"]) ? 1 : 0;

$stmt = $db->prepare("UPDATE video SET noplay = ? WHERE id = ?");
$stmt->bind_param("ii", $value, $id);
$stmt->execute();

$msg = "Video úspešne upravené.";
?>
<a href="index.php">Späť</a>
<?php echo htmlspecialchars($msg); ?>
