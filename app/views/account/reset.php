<form action="/account/reset" method="post">

  <h1 class="h2 mb-4 font-weight-normal header-form-sign-in">Восстановление пароля</h1>

  <div class="m-t-20 mb-3 link-reg">
    Для востановления пароля, Вам необходимо указать E-mail адрес от аккаунта, 
    пароль от которого был забыт и на который будет отправленно письмо, 
    содержащее новый пароль.
  </div>

  <label class="sr-only" for="email">E-mail</label>
  <input class="form-control mb-3" type="email" id="email" name="email" placeholder="Введите e-mail" 
  value="<?php echo $_SESSION['old']['email'] ?? ''?>" required autofocus>

  <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">Отправить</button>

  <div class="m-t-20 mb-3 link-reg">
    Уже зарегистрированы? Нажмите <a href="/account/sign-in">здесь</a>, что бы произвести вход в приложение.
  </div>

</form>