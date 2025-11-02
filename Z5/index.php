<?php
require_once 'session_config.php';

// Jeśli użytkownik jest już zalogowany, przekieruj go do panelu
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: Panel_Profil.php");
    exit();
}
?>
<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie i Rejestracja</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <main class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">
                <button class="btn btn-success w-50" style="height: 50px;" onclick="window.location.href='../index.php'">Powrót do menu</button>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row gx-3">
            <!-- Formularz logowania -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Logowanie</h2>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="loginUsername" class="form-label">Login</label>
                                <input type="text" class="form-control" id="loginUsername" name="username" placeholder="Wpisz login"
                                       required pattern="[A-Za-z0-9_]{1,999}" title="1-999 znaków">
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Hasło</label>
                                <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Wpisz hasło"
                                       required minlength="1" maxlength="999" title="Hasło do 999 znaków">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Zaloguj się</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Formularz rejestracji -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Rejestracja</h2>
                        <form method="POST" action="register.php" id="registerForm">
                            <div class="mb-3">
                                <label for="regUsername" class="form-label">Login</label>
                                <input type="text" class="form-control" id="regUsername" name="username" placeholder="Wpisz login"
                                       required pattern="[A-Za-z0-9_]{1,999}" title="">
                            </div>
                            <div class="mb-3">
                                <label for="regPassword" class="form-label">Hasło</label>
                                <input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Wpisz hasło"
                                       required minlength="1" maxlength="999" title="">
                            </div>
                            <div class="mb-3">
                                <label for="regPasswordConfirm" class="form-label">Powtórz hasło</label>
                                <input type="password" class="form-control" id="regPasswordConfirm" name="regPasswordConfirm"
                                       placeholder="Powtórz hasło" required minlength="1" maxlength="999">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Zarejestruj się</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        // Prosta walidacja zgodności haseł po stronie klienta
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('regPassword').value;
            const confirm = document.getElementById('regPasswordConfirm').value;
            if(password !== confirm) {
                e.preventDefault();
                alert('Hasła nie są identyczne!');
            }
        });
    </script>
</body>
</html>
