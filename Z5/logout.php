<?php
require_once 'session_config.php';

// Usuń wszystkie zmienne sesyjne
$_SESSION = [];

// Usuń ciasteczko sesyjne
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zniszcz sesję
session_destroy();

// Przekieruj na stronę logowania
header("Location: index.php");
exit();
?>
