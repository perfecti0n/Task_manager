<?php session_start(); include "header.php" ?>
<?php
require_once "config.php";
if(isset($_SESSION['user_id'])){
  $user_id=$_SESSION['user_id'];
}
else{
  showError("Вы не вошли в аккаунт <a href=\"login-form.php\">Войти</a> ");
}
$task_id=$_GET['task_id'];
$stmt=$pdo->prepare(SQL_GET_TASK_USERID_BY_TASKID);
  $stmt->execute([
  'task_id'=>$task_id
  ]);
  $task=$stmt->fetch(PDO::FETCH_ASSOC);
if($user_id!=$task['user_id']){
showError("Эта задача не принадлежит вам!<br> <a href=\"list.php\">Вернуться в список задач</a> <!-- ");
}
$stmt=$pdo->prepare(SQL_GET_TASK_BY_TASKID);
  $stmt->execute([
  'task_id'=>$task_id,
  ]);
  $task=$stmt->fetch(PDO::FETCH_ASSOC);
$task_name=$task['task_name'];
$task_description=$task['task_description'];
$task_img=$task['task_img'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="edit.php" method="POST" enctype="multipart/form-data" >
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Изменить запись</h1>
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" id="inputEmail" class="form-control" name="task_name"placeholder="" required value="<?php echo $task_name; ?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="task_description" class="form-control" cols="30" rows="10" placeholder=""><?php echo $task_description; ?></textarea>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="customSwitch2" name="isEdittingPhoto">
          <label class="custom-control-label" for="customSwitch2">Изменить картинку</label>
        </div>
        <input type="file" name="task_img">
        Текущая картинка:
        <img src="<?php echo $task_img; ?>" alt="" width="300" class="mb-3">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="customSwitch1" name="switch" >
          <label class="custom-control-label" for="customSwitch1">Включите чтобы сдeлать запись скрытой</label>
        </div>
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <a href="list.php">Вернуться в список задач</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
