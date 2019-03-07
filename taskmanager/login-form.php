<?php
require_once "config.php";
session_start();
if(isset($_SESSION['user_id'])){
  header("Location: list.php");
}else{
if (isset($_COOKIE['email'])) {
  $email=$_COOKIE['email'];
  $password=$_COOKIE['password'];
  $stmt=$pdo->prepare(SQL_GET_ALL_BY_EMAIL);
  $stmt->execute([
  'email'=>$email,
  ]);
  $res=$stmt->fetch(PDO::FETCH_ASSOC);
  $_SESSION['user_id']=$res['user_id'];
  header("Location: list.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="login.php" method="POST">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus name="email">
        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="inputPassword" class="form-control"  placeholder="Пароль" required name="password">
        <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="customCheck1" name="rememberMe">
        <label class="custom-control-label" for="customCheck1">Запомнить меня</label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        <a href="register-form.php">Зарегистрироваться</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
<?php
}
?>
