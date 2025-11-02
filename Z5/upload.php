<?php
require_once 'session_config.php';
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['username'];
$target_dir = __DIR__ . "/users/" . $user . "/";

if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "Plik został przesłany. <a href='mycloud.php'>Wróć</a>";
} else {
    echo "Błąd podczas przesyłania. <a href='mycloud.php'>Wróć</a>";
}
?>
