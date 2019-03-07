<?php session_start(); include "header.php" ?>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.js"></script>
<?php
require_once "config.php";
if(isset($_SESSION['user_id'])){
  $user_id=$_SESSION['user_id'];
}
else{
  showError("Вы не вошли в аккаунт <a href=\"login-form.php\">Войти</a> ");
}
$task_id=$_GET['task_id']; 
$stmt=$pdo->prepare(SQL_GET_TASK_BY_TASKID);
  $stmt->execute([
  'task_id'=>$task_id,
  ]);
  $task=$stmt->fetch(PDO::FETCH_ASSOC);
  if($user_id!=$task['user_id']){
showError("Эта задача не принадлежит вам!<br> <a href=\"list.php\">Вернуться в список задач</a> <!-- ");
}
$task_name=$task['task_name'];
$task_description=$task['task_description'];
$task_img=$task['task_img'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <img src="<?php echo $task_img; ?>" alt="" width="400">
      <h2><?php echo $task_name; ?></h2>
      <p>
        <!-- <?php echo $task_description; ?> -->
        <?php echo htmlentities($task_description); ?>
      </p>
      <a href="list.php">Список задач</a>
    </div>
  </body>
</html>
