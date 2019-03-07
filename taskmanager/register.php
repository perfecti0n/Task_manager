<?php 
require_once "config.php";
				//Получение данных из массива $_POST
$data=[
$name=$_POST['name'],
$email=$_POST['email'],
$password=$_POST['password']
];
				//Проверка данных
	//Проверка на пустоту
foreach ($data as $value) {
	if (empty($value)) {
		showError("Заполните все поля");
	}
}
	//Проверка длины пароля
if(mb_strlen($password)<8){
	showError("Пароль должен содержать 8 или больше символов");
}
	//Проверка на наличие данного email адреса в БД
// $res=$pdo->query(SQL_GET_USER_EMAILS,PDO::FETCH_ASSOC);
// $emailsFromDB=[];
// foreach ($res as $value) {
// 	$emailsFromDB[]=$value['email'];
// }
// foreach ($emailsFromDB as $value) {
// 	if ($value==$email) {
// 		$errMsg="Такой email ({$value}) уже существует!";
// 		include "errors.php";
// 		exit();
// 	}
// }
	$stmt=$pdo->prepare(SQL_GET_ALL_BY_EMAIL);
	$stmt->execute([
	'email'=>$email,
	]);
	$res=$stmt->fetchAll();
	if ($res==true) {
		showError("Такой email уже зарегистрирован!");
	}
				//Запись данных в БД
		//Подготовка запроса
$password=md5($password); //Хеширование пароля
$stmt=$pdo->prepare(SQL_USER_REGISTRATION);
		//Исполнение запроса
$res=$stmt->execute([
	'name'=>$name,
	'email'=>$email,
	'password'=>$password,
]);
if ($res!=true) {
	showError("Ошибка регистрации");
}
header("Location: login-form.php");

?>