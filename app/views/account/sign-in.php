<form action="/account/sign-in" method="post">

  <h1 class="h2 mb-4 font-weight-normal header-form-sign-in">Вход в приложение</h1>

  <label class="sr-only" for="login">Логин</label>
  <input class="form-control" type="text" id="login" name="login" placeholder="Введите логин" 
  value="<?php echo $_SESSION['old']['login'] ?? ''?>" required autofocus>

  <label class="sr-only" for="password">Пароль</label>
  <input class="form-control mb-3" type="password" id="password" name="password" placeholder="Введите пароль" required>

  <div class="checkbox checkbox-css mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Запомни меня
    </label>
  </div>

  <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">Войти</button>

  <div class="m-t-20 mb-3 link-reg">
    Еще не зарегистрированы? Нажмите <a href="/account/register">здесь</a>, чтобы зарегистрироваться.
  </div>

  <div class="m-t-20 link-forgot"><a class="" href="/account/reset">Забыли пароль?</a></div>

</form>