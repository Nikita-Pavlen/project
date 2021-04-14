<?php
echo '<div class="black_out" hidden>
</div>
<div class="success__message' . $isOpenedSuccess . '" hidden>
<p>' . $success . '</p>
</div>
<div class="register__form' . $isOpenedAuth . '" hidden>
  <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
  ' . $errorMsgAuth . '
    <p><h3>Вход</h3></p>
    <p><input type="text" name="login" placeholder="Логин" value="' . $loginAuthValue . '"></p>
    <p><input type="password" name="password" placeholder="Пароль"></p>
    <p><input type="submit" class="send__btn" value="Войти" name="login-send-btn"></p>
  </form>
  <p><button class="change__form__btn">Зарегистрироваться</button></p>
</div>
<div class="register__form registration' . $isOpenedRegister . '" hidden>
  <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
  ' . $errorMsgReg . '
      <p><h3>Регистрация</h3></p>
      <p><input type="text" name="login" id="reg_login" placeholder="Логин" data-helptext="0" value="' . $loginRegValue . '"></p>
     <div class="help__message info__message">Может содержать только заглавные или строчные латинские буквы и цифры. Длина не менее 6 символов и не более 16.</div>
     <div class="help__message mistake__message"></div>
      <p><input type="password" name="password" id="reg_password" placeholder="Пароль" data-helptext="1"></p>
      <div class="help__message info__message">Допустимые символы: заглавные и строчные латинские буквы, цифры, а так же символы (, ), [, ], {, }, -, _  Длина пароля должна быть не менее 8 символов.</div>
      <div class="help__message mistake__message"></div>
      <p><input type="password" name="sub_password" id="reg_sub_password" placeholder="Повторите пароль" data-helptext="2"></p>
      <div class="help__message mistake__message"></div>
      <p><input type="submit" id="register-form-send-btn" class="send__btn" value="Регистрация" name="register-send-btn" disabled></p>
    </form>
</div>';