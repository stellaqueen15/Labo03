<?php

$dsn = 'mysql:host=localhost;dbname=bddlabo02;charset=utf8';
$username = 'root';
$password = '';

try {
    $database = new PDO($dsn, $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
}