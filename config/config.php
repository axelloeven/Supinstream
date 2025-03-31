<?php

$host = getenv('CLEVER_MYSQL_HOST');
$user = getenv('CLEVER_MYSQL_USER');
$password = getenv('CLEVER_MYSQL_PASSWORD');
$dbname = getenv('CLEVER_MYSQL_DB');


if (!$host || !$user || !$password || !$dbname) {
    die("Les variables d'environnement pour la base de données ne sont pas définies.");
}


$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
