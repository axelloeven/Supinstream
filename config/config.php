<?php

$host= 'bxybxv53xgcywm2kr2yw-mysql.services.clever-cloud.com';
$username = 'usvcm9lpxtjc5edv';
$password = 'iD5keffJbUC3KCnDdL2i';
$dbname= 'bxybxv53xgcywm2kr2yw';

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

