<?php
// Wyłącz przekazywanie SID w URL
ini_set('session.use_trans_sid', 0);

if (session_status() === PHP_SESSION_NONE) {

    // Konfiguracja ciasteczek sesji
    session_set_cookie_params([
        'lifetime' => 1800, // 30 minut
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => isset($_SERVER['HTTPS']), // tylko po HTTPS
        'httponly' => true,  // niedostępne dla JS
        'samesite' => 'Lax'
    ]);

    session_start();
}

// Wygasanie sesji po 30 minutach braku aktywności
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
