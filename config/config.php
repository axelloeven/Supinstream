<?php

$host = '';
$username = '';
$password = '';
$dbname = '';

if (!$host || !$username || !$password || !$dbname) {
    die('Database credentials are not set in the environment variables.');
}
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>