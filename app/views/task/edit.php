<h1>Редактирование задачи</h1>

<form action="/tasks/update" method="post">
    <div class="form-group">
        <label for="users_name">Имя пользователя</label>
        <input class="form-control" type="text" id="users_name" name="users_name" 
        placeholder="Введите имя пользователя" value="<?php echo $value['users_name']?>" readonly><!--required-->
    </div>

    <div class="form-group">
        <label for="users_email">E-mail</label>
        <input class="form-control" type="email" id="users_email" name="users_email" aria-describedby="emailHelp" 
        placeholder="Введите E-mail" value="<?php echo $value['users_email']?>" readonly><!--required-->
    </div>

    <div class="form-group">
        <label for="task_text">Текст задачи <span class="text-theme">*</span></label><!--required-->
        <textarea class="form-control" id="task_text" name="task_text" 
        rows="5"><?php echo $_SESSION['old']['task_text'] ?? $value['task_text'] ?></textarea>
    </div>

    <input type="hidden" name="status" value="0">

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" 
        <?php echo $_SESSION['old']['status'] ?? ($value['status'] ? 'checked' : '');?> >
        <label class="form-check-label" for="status">Задача выполнена</label>
    </div>

    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="task_id" value="<?php echo $value['task_id']?>">

    <button class="btn btn-outline-primary" type="submit">Применить</button>
</form><br>
