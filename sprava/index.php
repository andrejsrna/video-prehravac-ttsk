<?php

require_once(__DIR__ . "/../connection.php");

require_once(__DIR__ . "/validation.php");

?>

<!doctype html>
<html lang="sk-SK">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>VIDEO APP</title>

<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="noindex,nofollow" />

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    * {
        box-sizing: border-box;
    }
    .container {
        max-width: 900px;
        margin: 40px auto;
    }
    body {
        font-family: "Open Sans";
    }
    img {
        max-width: 100%;
        height: auto;
        display: block;
    }
    input:not([type="file"]), textarea {
        width: 100%;
        height: 40px;
        font-size: 16px;
        background: white;
        border: 1px solid black;
        margin: 10px 0;
        padding: 0 15px;
        color: black;
        font-family: "Open Sans";
        border-radius: 4px;
    }
    input[type="file"] {
        margin-bottom: 10px;
    }
    input[type="checkbox"] {
        width: auto;
        height: auto;
    }
    textarea {
        height: auto;
        padding: 15px;
    }
    button {
        width: 100%;
        height: 50px;
        color: white;
        font-weight: 700;
        background: #4e97af;
        border: none;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
    }
    button:hover {
        background: #317c95;
    }
    table {
        margin-top: 40px;
        text-align: center;
        width: 100%;
    }
    table, tr, td, th {
        border: 1px solid black;
        border-collapse: collapse;
        position: relative;
    }
    table img {
        margin-right: 20px;
    }
    table a {
        text-decoration: none;
        color: red;
        font-weight: 700;
    }
    table th {
        padding: 10px;
    }
    video {
        display: block;
    }
    td:nth-child(2) {
        width: 200px;
        word-break: break-all;
    }
</style>

</head>
<body>
<?php
if (empty($_SESSION["authenticated"]))
    require __DIR__ . "/login.php";
else {
?>
<div class="container">
    <h1>Videá</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="video" id="video" required>
        <button type="submit" name="upload">Nahrať</button>
    </form>

    <table>
        <tr>
            <th>Video</th>
            <th>Názov</th>
            <th>Neprehrať v jedálni</th>
            <th>Dátum pridania</th>
            <th>Zmazať</th>
            <th>Uložiť</th>
        </tr>
    <?php
        $sql = "SELECT * FROM video ORDER BY created_at DESC";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <form action="edit.php" method="post">
                    <tr>
                        <td width="420">
                            <video controls muted src="<?php echo "../video/" . htmlspecialchars($row["link"]); ?>" width="420"></video>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row["link"]); ?>
                        </td>
                        <td><input type="checkbox" name="noplay" id="noplay" <?php echo ($row['noplay'] == 1 ? 'checked' : ''); ?>></td>
                        <td>
                            <?php
                                $date = date_create($row["created_at"]);
                                echo date_format($date, "d.m.Y H:i");
                            ?>
                        </td>
                        <td><a href="delete.php?delete=<?php echo (int) $row["id"]; ?>">X</a></td>
                        <td style="padding: 0 10px;">
                            <input type="hidden" name="id" id="id" value="<?php echo (int) $row['id']; ?>">
                            <button type="submit" name="upload">Uložiť</button>
                        </td>
                    </tr>
                </form>
            <?php
            }
        } else {
            echo "0 results";
        }
    ?>
    </table>

    <form method="post" action="" id="logout_form">
        <input type="submit" name="page_logout" value="Odhlásiť">
    </form>
</div>
<?php } ?>

</body>
</html>
