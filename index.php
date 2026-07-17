<?php

require_once(__DIR__ . "/connection.php");

$videos = [];
$result = $db->query("SELECT link FROM video WHERE noplay = 0 ORDER BY created_at ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row["link"];
    }
}

?>
<!doctype html>
<html lang="sk-SK">
<head>
<meta charset="utf-8">
<title>Video prehrávač</title>
<meta name="robots" content="noindex,nofollow" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background: #000;
        overflow: hidden;
    }
    #player {
        width: 100vw;
        height: 100vh;
        object-fit: contain;
        background: #000;
        display: block;
    }
    #empty {
        color: #888;
        font-family: sans-serif;
        text-align: center;
        padding-top: 45vh;
    }
</style>
</head>
<body>
<?php if (empty($videos)): ?>
    <p id="empty">Žiadne videá na prehratie.</p>
<?php else: ?>
    <video id="player" autoplay muted playsinline></video>
    <script>
        var playlist = <?php echo json_encode($videos); ?>;
        var index = 0;
        var player = document.getElementById('player');

        function playNext() {
            player.src = 'video/' + encodeURIComponent(playlist[index]);
            player.play().catch(function () {});
            index = (index + 1) % playlist.length;
        }

        player.addEventListener('ended', playNext);
        playNext();

        // Playlist sa mohol medzičasom zmeniť (nové/zmazané/vypnuté video) - obnov raz za hodinu
        setTimeout(function () {
            location.reload();
        }, 60 * 60 * 1000);
    </script>
<?php endif; ?>
</body>
</html>
