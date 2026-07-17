<?php

$host = getenv('DB_HOST') ?: 'mysql';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$name = getenv('DB_NAME') ?: 'video';

$db = mysqli_connect($host, $user, $pass, $name);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
