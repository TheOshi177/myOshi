<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) exit(header('Location: ../login.php'));

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$user = substr($user,0,32);
$userDir = realpath(__DIR__.'/users/'.$user);
if (!is_dir($userDir)) mkdir($userDir,0755,true);

$relDir = isset($_POST['dir']) ? trim($_POST['dir'], '/') : '';
$relDir = preg_replace('/[^A-Za-z0-9_\-\/]/','',$relDir);
$currentDir = realpath($userDir.'/'.$relDir);
if ($currentDir === false || strpos($currentDir,$userDir)!==0) $currentDir=$userDir;

if (!isset($_FILES['fileToUpload'])) { header('Location: mycloud.php'); exit; }

$file = $_FILES['fileToUpload'];
$name = basename($file['name']);
$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));

// Tylko bezpieczne typy plików
$allowed = ['jpg','jpeg','png','gif','mp3','mp4','webm','txt','pdf'];
if (!in_array($ext,$allowed)) { $_SESSION['flash_error']='Nieprawidłowy typ pliku.'; header('Location: mycloud.php?dir='.$relDir); exit; }

// Zmieniamy nazwę, by uniknąć konfliktów
$name = uniqid().'.'.$ext;
$path = $currentDir.'/'.$name;

if (move_uploaded_file($file['tmp_name'],$path)) {
    $_SESSION['flash_success']='Plik przesłany pomyślnie.';
} else {
    $_SESSION['flash_error']='Błąd podczas przesyłania pliku.';
}
header('Location: mycloud.php?dir='.$relDir);
exit;
?>
