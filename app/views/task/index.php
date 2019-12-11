<h1>Список задач</h1>

<div class="dataTables_wrapper">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="example_length">
                <label>Показать по 
                    <select onchange="top.location=this.value" name="limit" aria-controls="example"
                    class="custom-select custom-select-sm form-control form-control-sm">

                        <option value="/tasks?limit=5<?php echo $limit_last_url ?>" 
                            <?php if ($limit == 5) : ?>
                                selected
                            <?php endif ?>
                        >5</option>
                        <option value="/tasks?limit=10<?php echo $limit_last_url ?>" 
                            <?php if ($limit == 10) : ?>
                                selected
                            <?php endif ?>
                        >10</option>
                        <option value="/tasks?limit=25<?php echo $limit_last_url ?>" 
                            <?php if ($limit == 25) : ?>
                                selected
                            <?php endif ?>
                        >25</option>
                        <option value="/tasks?limit=50<?php echo $limit_last_url ?>" 
                            <?php if ($limit == 50) : ?>
                                selected
                            <?php endif ?>
                        >50</option>
                        <option value="/tasks?limit=100<?php echo $limit_last_url ?>" 
                            <?php if ($limit == 100) : ?>
                                selected
                            <?php endif ?>
                        >100</option>

                    </select> записей
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_filter" id="example_filter">
                <form action="/tasks" method="get" id="search" name="search">

                    <div class="input-group mb-3 input-group-search">

                        <input name="where" value="<?php echo $where ?>" type="search" 
                        class="form-control form-control-sm" placeholder="Поиск" aria-controls="example">

                        <?php echo $search_last_url ?>

                        <div class="input-group-append">
                            <button class="btn btn-search btn-sm btn-outline-secondary" id="btnSearch" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-hover table_sort">
        <thead class="thead-light">
            <tr>    
                <th class="pr-4 
                    <?php if (isset($sorting) and $sorting === 'name-asc') echo 'sorting_asc'; 
                          elseif (isset($sorting) and $sorting === 'name-desc') echo 'sorting_desc';
                    else echo 'sorting';
                    ?>">
                    <a href="tasks?<?php echo $sort_name ?>">Имя пользователя</a>
                </th>
                <th class="pr-4 
                    <?php if (isset($sorting) and $sorting === 'email-asc') echo 'sorting_asc'; 
                          elseif (isset($sorting) and $sorting === 'email-desc') echo 'sorting_desc';
                    else echo 'sorting';
                    ?>">
                    <a href="tasks?<?php echo $sort_email ?>">E-mail</a>
                </th>
                <th data-orderable="false">Текст задачи</th>
                <th class="pr-4 
                    <?php if (isset($sorting) and $sorting === 'status-asc') echo 'sorting_asc'; 
                          elseif (isset($sorting) and $sorting === 'status-desc') echo 'sorting_desc';
                    else echo 'sorting';
                    ?>">
                    <a href="tasks?<?php echo $sort_status ?>">Статус</a>
                </th>
                <?php if (isset($_SESSION['logged_user']['login'])) : ?>
                    <?php if ($_SESSION['logged_user']['role'] === 'admin') : ?>
                        <th>Действие</th>
                    <?php endif ?>
                <?php endif ?>
            </tr>
        </thead>
        <?php foreach($task_list as $value): ?>
            <tr>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['email'] ?></td>
                <td><?php echo $value['task_text'] ?></td>
                <td>
                    <?php echo $value['status'] ? 'Выполнено<br>' : '';?>
                    <?php echo $value['edited_by_admin'] ?
                     'Отредактировано администратором' : '';?>
                </td>
                <?php if (isset($_SESSION['logged_user']['login'])) : ?>
                    <?php if ($_SESSION['logged_user']['role'] === 'admin') : ?>
                        <td class="action">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-secondary" href="tasks/edit/<?php echo $value['task_id'];?>"
                                data-toggle="tooltip" data-placement="top" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a onclick="if(confirm('Удалить?')){ return true } else { return false }" 
                                class="btn btn-secondary" 
                                href="tasks/delete/<?php echo $value['task_id'];?>" 
                                data-toggle="tooltip" data-placement="top" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    <?php endif ?>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="example_info" role="status" aria-live="polite">
                <?php echo $data_tables_info ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <?php echo $pagination ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div> 

<p><a class="btn btn-dark" href="tasks/create"><i class="fas fa-plus-circle"></i> Создать новую задачу</a></p>
