<?php
require_once "config.php";

				//Получение данных
session_start(); 
$task_name=$_POST['task_name'];
$task_description=$_POST['task_description'];
if(isset($_SESSION['user_id'])){
	$user_id=$_SESSION['user_id'];
}
else{
	showError("Вы не вошли в аккаунт <a href=\"login-form.php\">Войти</a> <!-- ");
}
if (isset($_POST['switch']) and $_POST['switch']=="on") {
	$task_isHidden="yes";
}
if(!isset($_POST['switch']) or $_POST['switch']=="off"){
	$task_isHidden="no";
}
if(!empty($_FILES['task_img']['name'])){	
$task_img_name=$_FILES['task_img']['name'];
$task_img_tmp_name=$_FILES['task_img']['tmp_name'];
$noImg=false;
}
if(empty($_FILES['task_img']['name'])){
	$noImg=true;
}
// var_dump(get_defined_vars());
// exit();
// echo $task_img_tmp_name."<br>";
// echo $task_img_name;
// exit();
				//Получение формата картинки для последующей генерации названия
if($noImg==false){
$regexp="/\.([A-Za-z]+)/ui";
$matches=[];
preg_match($regexp,$task_img_name,$matches);
$task_img_format=$matches[1];
if ($task_img_format=="png" or $task_img_format=="jpg" or $task_img_format=="jpeg") {
}
else{
showError("Загрузите изображение формата png,jpg или jpeg");
}
}
				//Запись данных в БД
$stmt=$pdo->prepare(SQL_INSERT_TASK);
$res=$stmt->execute([
'task_name'=>$task_name,
'task_description'=>$task_description,
'user_id'=>$user_id,
'task_isHidden'=>$task_isHidden
]);
if ($res!=true) {
	showError("Ошибка регистрации");
}

				//Генерация названия картинки и загрузка на сервер
if($noImg==false){
$task_img_id=$pdo->lastInsertId();
$task_img_name="task_img_".$task_img_id.".".$task_img_format;
$task_img_path="uploads/".$task_img_name;
move_uploaded_file($task_img_tmp_name,$task_img_path);
}
if($noImg==true){
	$task_img_path="/uploads/no-image.jpg";
}
				//Запись данных в БД
$stmt=$pdo->prepare(SQL_INSERT_TASK_IMG);
$stmt->execute([
'task_img'=>$task_img_path
]);
header("Location: list.php");
?>
