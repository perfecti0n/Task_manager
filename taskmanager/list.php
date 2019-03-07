<?php
require_once "config.php";
session_start();
if(isset($_SESSION['user_id'])){
  $user_id=$_SESSION['user_id'];
}
else{
  showError("Вы не вошли в аккаунт <a href=\"login-form.php\">Войти</a> ");
}
$stmt=$pdo->prepare(SQL_GET_ALL_BY_USERID);
  $stmt->execute([
  'user_id'=>$user_id,
  ]);
$res=$stmt->fetch(PDO::FETCH_ASSOC);
$userdata=$res;
// var_dump($userdata);
$stmt=$pdo->prepare(SQL_GET_TASKS_BY_USERID);
  $stmt->execute([
  'user_id'=>$user_id,
  ]);
$res=$stmt->fetchAll(PDO::FETCH_ASSOC);
$tasks=$res;
 // var_dump($tasks);
if (isset($_GET['hiddenTasks'])==true) {
$hiddenTasks=$_GET['hiddenTasks'];
}
elseif(isset($_GET['hiddenTasks'])==false){
$hiddenTasks=$_SESSION['hiddenTasks'];
}
// var_dump($_GET);
// var_dump($_SESSION);
// echo $hiddenTasks;
// exit();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Tasks</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>

  <body>

    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">О проекте</h4>
              <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white"><?php echo $userdata['email'] ?></h4>
              <ul class="list-unstyled">
                <li><a href="logout.php" class="text-white">Выйти</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php include "header.php" ?>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Проект Task-manager</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
          <p>
            <a href="create-form.php" class="btn btn-primary my-2">Добавить запись</a>
          </p>
          <form action="list.php" method="GET">
            <input type="hidden" name="hiddenTasks" value="<?php if($hiddenTasks=='off') {echo "on";$_SESSION['hiddenTasks']='off';}  if($hiddenTasks=='on') {echo "off";$_SESSION['hiddenTasks']='on';} ?>">
          <button type="submit"><?php if($hiddenTasks=='off'){echo "Включить отображение скрытых задач";} if($hiddenTasks=='on') {echo "Выключить отображение скрытых задач";} ?></button>
          </form>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <!--  -->
            <?php foreach ($tasks as $task) {
                if($hiddenTasks=='off' AND $task['task_isHidden']=='yes'){ continue; }
                if($task['task_isHidden']=='yes'){$task_name=$task['task_name']."<span class=\"text-muted\">(скрытая)</span>";}
                else{
                $task_name=$task['task_name'];
                }
                $task_id=$task['task_id'];
                $task_img=$task['task_img'];
              ?>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="<?php echo $task_img; ?>">
                <div class="card-body">
                  <p class="card-text"><?php echo $task_name; ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="show.php?task_id=<?php echo $task_id; ?>" class="btn btn-sm btn-outline-secondary">Подробнее</a>
                      <a href="edit-form.php?task_id=<?php echo $task_id; ?>" class="btn btn-sm btn-outline-secondary">Изменить</a>
                      <a href="delete.php?task_id=<?php echo $task_id; ?>"class="btn btn-sm btn-outline-secondary" onclick="confirm('Are you sure?')">Удалить</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <!--  -->
          </div>
        </div>
      </div>

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Наверх</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
