<?php 
require_once "config.php";
				//Получение данных из массива $_POST
$email=$_POST['email'];
$password=$_POST['password'];
$passwordForCookie=$_POST['password'];
if(isset($_POST['rememberMe'])){
$rememberMe=$_POST['rememberMe'];
}else{
	$rememberMe='off';
}
				//Проверка данных
		//Проверка на пустоту
if (empty($email)==true or empty($password)==true) {
	include "errors.php";
	exit();
}
		//Проверка на налчиие email в БД
	$stmt=$pdo->prepare(SQL_GET_ALL_BY_EMAIL);
	$stmt->execute([
	'email'=>$email,
	]);
	$res=$stmt->fetch(PDO::FETCH_ASSOC);
	if ($res!=true) {
		$errMsg="Такого email ({$email}) не существует!";
		include "errors.php";
		exit();
	}
		//Проверка на совпадение пароля
	$hashedPassword=md5($password);
	if ($hashedPassword!=$res['password']) {
		$errMsg="Такого совпадения логина и пароля не найдено";
		include "errors.php";
		exit();
	}
		//Запись пользователя в сессию
	session_start();
	$_SESSION['user_id']=$res['user_id'];
	$_SESSION['hiddenTasks']='off';
	if ($rememberMe=="on") {
		setcookie("email",$email,time()+24*60*60*31);
		setcookie("password",$passwordForCookie,time()+24*60*60*31);
	}
	header("Location: list.php")
?>