<form action="/account/register" method="post">

  <h1 class="h2 mb-4 font-weight-normal header-form-sign-in">Регистрация</h1>

  <label class="sr-only" for="login">Логин</label>
  <input class="form-control" type="text" id="login" name="login" placeholder="Введите логин" 
  value="<?php echo $_SESSION['old']['login'] ?? ''?>" required autofocus>

  <label class="sr-only" for="email">E-mail</label>
  <input class="form-control" id="email" type="email" name="email" placeholder="Введите e-mail" 
  value="<?php echo $_SESSION['old']['email'] ?? ''?>" required>

  <label class="sr-only" for="password">Пароль</label>
  <input class="form-control mb-3" type="password" id="password" name="password" placeholder="Введите пароль" required>

  <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">Зарегистрироваться</button>

  <div class="m-t-20 mb-3 link-reg">
    Уже зарегистрированы? Нажмите <a href="/account/sign-in">здесь</a>, что бы произвести вход в приложение.
  </div>

</form>