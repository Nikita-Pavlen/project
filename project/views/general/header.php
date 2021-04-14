<?php
$model = new \Core\Model();

$isOpenedRegister = '';
$isOpenedAuth = '';
$isOpenedSuccess = '';
$errorMsgReg = '';
$errorMsgAuth = '';
$loginAuthValue = '';
$loginRegValue = '';
$success = '';
$isHiddenLogin = '';
$isHiddenLogout = ' hidden';
$isHiddenAdmin = ' hidden';

if (isset($_POST['register-send-btn'])) {
  $login = $_POST['login'];
  $result = $model->getUser ($login);

  if ($result) {
    $errorMsgReg = '<p class="error-message">Такой логин уже существует</p>';
    $isOpenedRegister = ' openedElem';
    $loginRegValue = $login;
  } else {
    $model->addUser ($login, password_hash ($_POST['password'], PASSWORD_DEFAULT));
    $_SESSION['auth'] = 1;
    $_SESSION['banned'] = 0;
    $_SESSION['user_login'] = $login;
    $_SESSION['success_auth'] = 'registration';

    header ('Location: ' . $_SERVER['REQUEST_URI']);
    session_write_close ();
    exit();
  }
} else if (isset($_POST['login-send-btn'])) {
  $login = $_POST['login'];
  $user = $model->getUser ($login);

  if ($user) {
    $password = $_POST['password'];
    if (!password_verify ($password, $user['password'])) {
      $isOpenedAuth = ' openedElem';
      $loginAuthValue = $login;
      $errorMsgAuth = '<p class="error-message">Неверная пара логин-пароль</p>';
    } else {
      $_SESSION['auth'] = $user['status'];
      $_SESSION['banned'] = $user['banned'];
      $_SESSION['user_login'] = $login;
      $_SESSION['success_auth'] = 'login';

      header ('Location: ' . $_SERVER['REQUEST_URI']);
      session_write_close ();
      exit();
    }
  } else {
    $isOpenedAuth = ' openedElem';
    $loginAuthValue = $login;
    $errorMsgAuth = '<p class="error-message">Неверная пара логин-пароль</p>';
  }
}

if (isset($_SESSION['success_auth'])) {
  $isOpenedSuccess = ' openedElem';
  if ($_SESSION['success_auth'] == 'registration') {
    $success = 'Регистрация прошла успешно';
  } else $success = 'Вы вошли успешно';
  unset($_SESSION['success_auth']);
}

if (isset($_SESSION['auth'])) {
  $isHiddenLogin = ' hidden';
  $isHiddenLogout = '';
  if ($_SESSION['auth'] == 2) {
    $isHiddenAdmin = '';
  }
}

$href = str_replace ('/', '@', $_SERVER['REQUEST_URI']);

echo '<header>
  <div class="header__content">
    <div class="header__left-content">
      <div class="header__logo">
        <a href="/"><img src="/project/webroot/img/logo.png" alt="Логотип сайта"></a>
      </div>
      <div class="github__logo">
        <a href="https://github.com/Nikita-Pavlen/project"><img src="/project/webroot/img/github_logo.png" alt="Ссылка на GitHub"></a>
      </div>
    </div>
    <nav class="header__menu">
      <ul>
        <li' . $isHiddenAdmin . '><a href="/admin/users" class="in__admin">Управление</a></li>
        <li><a href="/wishlist" class="wishlist">Желаемое<span></span></a></li>
        <li><a href="/cart" class="cart">Корзина<span></span></a></li>
        <li' . $isHiddenLogin . '><span class="header__btn-account">Войти</span></li>
        <li' . $isHiddenLogout . '><a href="/logout/' . $href . '" class="header__btn-account">Выйти</a></li>
      </ul>
    </nav>
  </div>
</header>';