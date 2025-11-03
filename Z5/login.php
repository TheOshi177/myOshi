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
$password = trim($_POST['password'] ?? '');

// Walidacja
if (empty($username) || empty($password)) {
    die("Podaj login i hasło.");
}

if (!preg_match('/^[A-Za-z0-9_]{1,20}$/', $username)) {
    die("Niepoprawny login.");
}

if (strlen($password) < 1 || strlen($password) > 50) {
    die("Niepoprawne hasło.");
}

// Sprawdzenie użytkownika i pobranie is_admin
$stmt = $pdo->prepare("SELECT id, username, password, is_admin FROM users5 WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Poprawne logowanie
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['loggedin'] = true;
    $_SESSION['is_admin'] = $user['is_admin'] ?? false;

    // 🔹 Zapis logowania do tabeli user_logins (Opcja B)
    $stmt2 = $pdo->prepare("INSERT INTO user_logins (username) VALUES (?)");
    $stmt2->execute([$user['username']]);

    header("Location: Panel_Profil.php");
    exit();
} else {
    echo "<script>alert('Błędny login lub hasło!'); window.location.href='index.php';</script>";
    exit();
}
?>
