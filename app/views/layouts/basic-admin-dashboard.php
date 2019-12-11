<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="icon" href="/public/assets/img/favicon/favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="/public/assets/css/basic-admin-dashboard.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Task manager</a>
            <input class="form-control form-control-dark w-100" type="text" placeholder="Поиск" aria-label="Search">

        <?php if (isset($_SESSION['logged_user']['login'])) : ?>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/account/logout">
                        <?php echo $_SESSION['logged_user']['login']?> | Выйти
                    </a>
                </li>
            </ul> 
        <?php else: ?>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/account/sign-in">Войти</a>
                </li>
            </ul>
        <?php endif ?>

    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">

                        <?php 
                        $menu = include_once './app/config/menu.php';
                        $current_url = $_SERVER["REQUEST_URI"];
                        if (preg_match('/\/\w+/', $current_url, $matches)) {
                            $current_url = $matches[0];
                        }
                        ?>
                        <?php foreach ($menu as $key => $value): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_url == $value['url']) ? 'active' : '' ;?>"
                               href="<?php echo $value['url'];?>">
                               <i class="<?php echo $value['icon'];?>" aria-hidden="true"></i> 
                               <?php echo $value['title'];?>
                           </a>
                        </li>
                        <?php endforeach; ?>
                        
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-3">
                <?php echo $content; ?>
                <?php 
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";
                    unset($_SESSION['success']);
                    unset($_SESSION['old']);
                }
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                    unset($_SESSION['error']);
                    unset($_SESSION['old']);
                }
                ?>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" 
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <?php if (preg_match('/\/tasks*/', $_SERVER["REQUEST_URI"])) :?>
    <script src="/public/assets/js/tasks.js"></script>
    <?php endif ?>
</body>
</html>