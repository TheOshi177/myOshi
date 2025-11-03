<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) exit;

$user = preg_replace('/[^A-Za-z0-9_\-]/','',$_SESSION['username']);
$user = substr($user,0,32);
$userDir = realpath(__DIR__.'/users/'.$user);

if (!isset($_GET['file'])) { header('Location: mycloud.php'); exit; }

$target = str_replace(['..','\\'], '', $_GET['file']);
$path = realpath($userDir.'/'.$target);
if ($path===false || strpos($path,$userDir)!==0) { $_SESSION['flash_error']='Nieprawidłowa ścieżka.'; header('Location: mycloud.php'); exit; }

function deleteDir($dir){
    if (!file_exists($dir)) return;
    if (is_file($dir) || is_link($dir)) { unlink($dir); return; }
    foreach(scandir($dir) as $item){ if($item==='.'||$item==='..') continue; deleteDir($dir.DIRECTORY_SEPARATOR.$item); }
    rmdir($dir);
}

deleteDir($path);
$_SESSION['flash_success']='Usunięto pomyślnie.';
header('Location: mycloud.php');
exit;
?>
