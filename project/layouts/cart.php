<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
  <link rel="stylesheet" href="/project/webroot/css/fontsv.css">
  <link rel="stylesheet" href="/project/webroot/css/generalv0.css">
  <link rel="stylesheet" href="/project/webroot/css/blackout.css">
  <link rel="stylesheet" href="/project/webroot/css/windowv2.css">
  <title><?= $title ?></title>
</head>
<body>
<div class="message" hidden>
  <h3>Спасибо за покупку.</h3>
  <a href="/">
    <button class="btn on-main-page">Вернуться на главную</button>
  </a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/project/views/general/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/project/views/general/form.php';
echo $content;
include $_SERVER['DOCUMENT_ROOT'] . '/project/views/general/footer.php';
?>
<script src="/project/webroot/js/getcookie.js"></script>
<script src="/project/webroot/js/checkCounters.js"></script>
<script src="/project/webroot/js/blackoutWindowv3.js"></script>
<script src="/project/webroot/js/deleteCartContentv2.js"></script>
</body>
</html>
