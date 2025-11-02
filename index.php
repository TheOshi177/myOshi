<!doctype html>
<html lang="pl">

<head>
  <link rel="shortcut icon" href="https://seohost.pl/files/main/favicon.png" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Strona domyślna">
  <title>Hubert Wełnic</title>
  <link href="https://default.seohost.pl/style.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <!-- Strona główna -->
  <main>
    <div class="container mt-4">
      <div class="domain-section mt-3">
        <h1 class="domain-title">Hubert Wełnic</h1>
      </div>
      <div class="container text-center">
        <div class="row gy-4 ">
          <div class="col-3"></div>
          <div class="col-md-3 d-grid gap-2">
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z1/index.php'">Zadanie - 1</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z1/index.php'">Zadanie - 2</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z3/index.php'">Zadanie - 3</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z4/index.php'">Zadanie - 4</button>
          </div>
          <div class="col-md-3 d-grid gap-2">
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z5/index.php'">Zadanie - 5</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z6/index.php'">Zadanie - 6</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z7/index.php'">Zadanie - 7</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='/Z8/index.php'">Zadanie - 8</button>
          </div>
          <div class="col-3"></div>
        </div>
      </div>
      <div class="default-page-notice mt-3">
        <div class="notice-content">
          <span class="notice-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 8v4"/>
              <circle cx="12" cy="16" r="1" fill="currentColor"/>
            </svg>
          </span>
          <p class="notice-text">
            <span class="lang-pl">To jest strona Główna. Hubert Wełnic</span>
            <span class="lang-en" style="display:none;">This is the default page. To change it, upload files to</span>
            <code>Prog. Aplikacji Sieciowych</code>
          </p>
        </div>
        <p class="notice-footer">
          <span class="lang-pl">utworzono: Mon Oct 6 09:47:35 2025</span>
          <span class="lang-en" style="display:none;">created: Mon Oct 6 09:47:35 2025</span>
        </p>
      </div>
    </div>
  </main>

  <script>
    // Automatyczne wykrywanie języka przeglądarki
    (function() {
      const userLang = navigator.language || navigator.userLanguage;
      const isPolish = userLang.toLowerCase().startsWith('pl');
      if (!isPolish) {
        document.querySelectorAll('.lang-pl').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.lang-en').forEach(el => {
          if (el.tagName === 'SPAN') el.style.display = 'inline';
          else el.style.display = 'block';
        });
        document.documentElement.lang = 'en';
      }
    })();
  </script>

</body>

</html>