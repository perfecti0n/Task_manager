<?php
require_once "config.php";
session_start();
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
          //Удаление картники на сервере
  $stmt=$pdo->prepare(SQL_GET_TASKIMG_BY_TASKID);
  $stmt->execute(['task_id'=>$task_id]);
  $res=$stmt->fetch(PDO::FETCH_ASSOC);
  $task_img=$res['task_img'];
  if($task_img!='/uploads/no-image.jpg'){
  unlink($task_img);
  }
$stmt=$pdo->prepare(SQL_DELETE_TASK_BY_TASKID);
  $res=$stmt->execute([
  'task_id'=>$task_id
  ]);
  if(!$res){
  	showError("Ошибка удаления!");
  }
header("Location: list.php");
?>

