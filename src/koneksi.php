<?php

declare(strict_types=1);

if (str_contains($_SERVER['HTTP_HOST'], 'ddev.site')) {
    $host = 'db';
    $db = 'db_hotel';
    $charset = 'utf8mb4';
    $user = 'root';
    $pass = 'root';
} else {
    $host = "localhost";
    $db = 'db_hotel';
    $charset = 'utf8mb4';
    $user = 'root';
    $pass = 'RidhoDB';
}


$dsn = "mysql:host={$host}; dbname={$db}; charset={$charset}";

$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage());
}
