<?php

$dbname = 'bob-vance';
$user = 'bit_academy';
$pass = 'bit';
$host = 'localhost';
$dsn = sprintf("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $dbname);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_ASSOC,
];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    $conn = new PDO($dsn, $user, $pass, $options);
    if ($conn) {
        header("Location: home.php");
        exit;
        // echo "connected to db of '" . $dbname . "' with version:";
        // echo $conn->query('SELECT VERSION()')->fetchColumn();
    }
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
