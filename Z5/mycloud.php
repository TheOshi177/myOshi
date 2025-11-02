<?php
require_once 'session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];
$user_dir = __DIR__ . "/users/" . $user;

if (!is_dir($user_dir)) {
    mkdir($user_dir, 0755, true);
}

$files = scandir($user_dir);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>MyCloud - <?php echo htmlspecialchars($user); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Witaj, <?php echo htmlspecialchars($user); ?>!</h2>
    <h4>Twój katalog: <?php echo $user; ?></h4>
    <hr>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Wybierz plik do wysłania:</label>
        <input type="file" name="fileToUpload" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Wyślij</button>
    </form>

    <hr>
    <h5>Twoje pliki:</h5>
    <ul>
        <?php
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            echo "<li><a href='download.php?file=" . urlencode($file) . "'>$file</a> 
                  - <a href='delete.php?file=" . urlencode($file) . "'>Usuń</a></li>";
        }
        ?>
    </ul>

    <a href="logout.php" class="btn btn-danger mt-3">Wyloguj</a>
</body>
</html>
