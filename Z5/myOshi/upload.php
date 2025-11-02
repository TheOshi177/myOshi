<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$userDir = __DIR__ . '/users/' . $user;
if (!is_dir($userDir)) mkdir($userDir, 0755, true);

if (!isset($_FILES['fileToUpload'])) {
    header('Location: mycloud.php');
    exit;
}

$file = $_FILES['fileToUpload'];
$name = basename($file['name']);
$path = $userDir . '/' . $name;

if (move_uploaded_file($file['tmp_name'], $path)) {
    header('Location: mycloud.php');
} else {
    echo "Błąd podczas przesyłania pliku.";
}
?>
