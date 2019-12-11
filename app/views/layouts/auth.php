<!doctype html>
<html lang="en">
<head>   
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta charset="utf-8">
  <link rel="icon" href="/public/assets/img/favicon/favicon.ico">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/sign-in/">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
  integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/public/assets/css/signin.css">
  <title><?php echo $title; ?></title>
</head>

<body class="text-center">

  <div class="form-signin">

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

    <p class="mt-5 mb-3 text-muted text-center">&copy; Alexander Shelobaev 2019</p>

  </div>

</body>
</html>