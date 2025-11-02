<?php
// connect.php - połączenie z bazą danych
$host = 'localhost';
$db   = 'srv95537_profile';
$user = 'srv95537_Admin';
$pass = 'Nsx44mut9tHjYphKp3XN';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą: " . htmlspecialchars($e->getMessage()));
}
