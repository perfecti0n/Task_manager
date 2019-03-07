<?php
require_once "config.php";

				//Получение данных
session_start();
$task_id=$_POST['task_id'];
// echo "$task_id";
// exit;
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
elseif(!isset($_POST['switch']) or $_POST['switch']=="off"){
	$task_isHidden="no";
}
if (isset($_POST['isEdittingPhoto']) and $_POST['isEdittingPhoto']=="on") {
	$isEdittingPhoto=true;
}
elseif(!isset($_POST['isEdittingPhoto']) or $_POST['isEdittingPhoto']=="off"){
	$isEdittingPhoto=false;
}
if(empty($_FILES['task_img']['name'])==false){	
$task_img_name=$_FILES['task_img']['name'];
$task_img_tmp_name=$_FILES['task_img']['tmp_name'];
$noImg=false;
}
elseif(empty($_FILES['task_img']['name'])==true){
	$noImg=true;
}
				//Обновление данных в БД
$stmt=$pdo->prepare(SQL_UPDATE_TASK_WITHOUT_IMG);
$res=$stmt->execute([
'task_name'=>$task_name,
'task_description'=>$task_description,
'task_isHidden'=>$task_isHidden,
'task_id'=>$task_id
]);
if ($res!=true) {
	showError("Ошибка редактирования записи");
}
if ($isEdittingPhoto==true) {
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
					//Удаление старой картники
	$stmt=$pdo->prepare(SQL_GET_TASKIMG_BY_TASKID);
	$stmt->execute(['task_id'=>$task_id]);
	$res=$stmt->fetch(PDO::FETCH_ASSOC);
	$task_img=$res['task_img'];
	if($task_img!="/uploads/no-image.jpg"){	
	unlink($task_img);
	}
					//Генерация названия картинки и загрузка на сервер
	if($noImg==false){
	$task_img_id=$task_id;
	$task_img_name="task_img_".$task_img_id.".".$task_img_format;
	$task_img_path="uploads/".$task_img_name;
	move_uploaded_file($task_img_tmp_name,$task_img_path);
	}
	elseif($noImg==true){
		$task_img_path="/uploads/no-image.jpg";
	}
					//Запись данных в БД
	$stmt=$pdo->prepare(SQL_UPDATE_TASK_IMG);
	$stmt->execute([
	'task_img'=>$task_img_path,
	'task_id'=>$task_id
	]);
}
// var_dump(get_defined_vars());
// exit;
	header("Location: list.php");