<?php
require_once __DIR__ . '/../session_config.php';
require_once __DIR__ . '/../connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$userDir = __DIR__ . '/users/' . $user;

if (!is_dir($userDir)) {
    mkdir($userDir, 0755, true);
}

$files = array_diff(scandir($userDir), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>MyCloud - <?php echo htmlspecialchars($user); ?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>📁 MyCloud — <?php echo htmlspecialchars($user); ?></h2>

    <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-3">
        <input type="file" name="fileToUpload" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Prześlij plik</button>
    </form>

    <form action="mkdir.php" method="post" class="mb-3">
        <input type="text" name="dirname" placeholder="Nazwa katalogu" class="form-control mb-2" required>
        <button type="submit" class="btn btn-secondary">Utwórz folder</button>
    </form>

    <h4>Twoje pliki:</h4>
    <ul class="list-group mb-3">
        <?php foreach ($files as $f): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo htmlspecialchars($f); ?>
                <div>
                    <a href="download.php?file=<?php echo urlencode($f); ?>" class="btn btn-success btn-sm">Pobierz</a>
                    <a href="delete.php?file=<?php echo urlencode($f); ?>" class="btn btn-danger btn-sm">Usuń</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="../Panel_Profil.php" class="btn btn-outline-secondary">Powrót</a>
</body>
</html>
