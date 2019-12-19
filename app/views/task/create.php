<h1>Создание задачи</h1>

<form action="/tasks/create" method="post">
    <div class="form-group">
        <label for="users_name">Имя пользователя <span class="text-theme">*</span></label>
        <input class="form-control" type="text" id="users_name" name="users_name" 
        placeholder="Введите имя пользователя" value="<?php echo $_SESSION['old']['users_name'] ?? ''?>">
        <!--required-->
        <small class="form-text text-muted" id="users_name">Текст длиною не более 100 символов</small>
    </div>

    <div class="form-group">
        <label for="users_email">E-mail <span class="text-theme">*</span></label>
        <input class="form-control" type="email" id="users_email" name="users_email" 
        aria-describedby="emailHelp" placeholder="Введите E-mail" 
        value="<?php echo $_SESSION['old']['users_email'] ?? ''?>"><!--required-->
        <small class="form-text text-muted" id="users_email">Текст длиною не более 100 символов</small>
    </div>

    <div class="form-group">
        <label for="task_text">Текст задачи <span class="text-theme">*</span></label><!--required-->
        <textarea class="form-control" id="task_text" name="task_text" 
        rows="5"><?php echo $_SESSION['old']['task_text'] ?? ''?></textarea>
    </div>

    <input type="hidden" name="_method" value="create">
    <button class="btn btn-secondary" type="submit">Добавить задачу</button>

</form><br>
