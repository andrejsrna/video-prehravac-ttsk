<?php
session_start();

if (isset($_POST['submit_pass']) && $_POST['pass']) {
    $pass = (string) $_POST['pass'];
    $expected = (string) (getenv('APP_PASSWORD') ?: '');

    if ($expected !== '' && hash_equals($expected, $pass)) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "Nesprávne heslo";
    }
}

if (isset($_POST['page_logout'])) {
    unset($_SESSION['authenticated']);
}
