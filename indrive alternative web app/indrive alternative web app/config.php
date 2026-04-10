<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = new PDO('mysql:host=localhost;dbname=mp', 'root', '');


$host = 'localhost';
$dbname = 'realstate';
$username = 'root';
$password = '';

try {
   $pdo = new PDO(
        "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}
?>