<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) exit(header('Location: ../login.php'));

$user = preg_replace('/[^A-Za-z0-9_\-]/','',$_SESSION['username']);
$user = substr($user,0,32);
$userDir = realpath(__DIR__.'/users/'.$user);
if (!is_dir($userDir)) mkdir($userDir,0755,true);

$relDir = isset($_POST['dir']) ? trim($_POST['dir'],'/') : '';
$relDir = preg_replace('/[^A-Za-z0-9_\-\/]/','',$relDir);
$currentDir = realpath($userDir.'/'.$relDir);
if ($currentDir===false || strpos($currentDir,$userDir)!==0) $currentDir=$userDir;

if (!isset($_POST['dirname'])) { $_SESSION['flash_error']='Brak nazwy katalogu.'; header('Location: mycloud.php?dir='.$relDir); exit; }

$dirname = preg_replace('/[^A-Za-z0-9_\-]/','',$_POST['dirname']);
$dirname = substr($dirname,0,64);
if ($dirname==='') { $_SESSION['flash_error']='Nieprawidłowa nazwa katalogu.'; header('Location: mycloud.php?dir='.$relDir); exit; }

$target = $currentDir.'/'.$dirname;
if (!is_dir($target)) {
    if (mkdir($target,0755)) {
        $_SESSION['flash_success']='Katalog utworzony.';
    } else {
        $_SESSION['flash_error']='Nie udało się utworzyć katalogu.';
    }
} else {
    $_SESSION['flash_error']='Katalog już istnieje.';
}
header('Location: mycloud.php?dir='.$relDir);
exit;
?>
