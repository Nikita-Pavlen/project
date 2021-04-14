<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/project/webroot/css/generalv0.css">
  <link rel="stylesheet" href="/project/webroot/css/error.css">
  <title><?= $title ?></title>
</head>
<body>
<header>
  <div class="header__content">
    <div class="header__left-content">
      <div class="header__logo">
        <a href="/"><img src="/project/webroot/img/logo.png" alt="Логотип сайта"></a>
      </div>
      <div class="github__logo">
        <a href="https://github.com/Nikita-Pavlen/project"><img src="/project/webroot/img/github_logo.png" alt="Ссылка на GitHub"></a>
      </div>
    </div>
  </div>
</header>
<?php
echo $content;
include $_SERVER['DOCUMENT_ROOT'] . '/project/views/general/footer.php';
?>
</body>
</html>
