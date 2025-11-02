<?php
require_once 'session_config.php';

// Połączenie z bazą
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

// Pobranie danych z formularza
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['regPassword'] ?? '');
$repeatPassword = trim($_POST['regPasswordConfirm'] ?? '');

// Walidacja
if (empty($username) || !preg_match('/^[A-Za-z0-9_]{4,20}$/', $username)) {
    die("Niepoprawny login (tylko litery, cyfry i _; 4-20 znaków).");
}

if (empty($password) || strlen($password) < 1 || strlen($password) > 99) {
    die("Hasło musi mieć od 6 do 99 znaków.");
}

if ($password !== $repeatPassword) {
    die("Hasła nie są takie same.");
}

// Sprawdzenie, czy login już istnieje
$stmt = $pdo->prepare("SELECT id FROM users5 WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    die("Login już istnieje.");
}

// Zapis użytkownika do bazy
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO users5 (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

header("Location: index.php");
exit();
?>
