<?php
$pdo=new PDO("mysql:host=localhost;dbname=task_manager",'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
const SQL_GET_ALL_BY_EMAIL="SELECT * FROM `users` WHERE `email`=:email"; 
const SQL_GET_ALL_BY_USERID="SELECT * FROM `users` WHERE `user_id`=:user_id";
const SQL_GET_TASKS_BY_USERID="SELECT * FROM `tasks` WHERE `user_id`=:user_id ";
const SQL_GET_TASK_BY_TASKID="SELECT * FROM `tasks` WHERE `task_id`=:task_id";
const SQL_GET_TASK_USERID_BY_TASKID="SELECT `user_id` FROM `tasks` WHERE `task_id`=:task_id";
const SQL_DELETE_TASK_BY_TASKID="DELETE FROM `tasks` WHERE task_id=:task_id";
//const SQL_GET_USER_PASSWORD="SELECT `password` FROM `users` WHERE `email`=:email"; 
const SQL_USER_REGISTRATION="INSERT INTO `users` (`name`,`email`,`password`) VALUES (:name,:email,:password)";
const SQL_INSERT_TASK="INSERT INTO `tasks` (`task_name`,`task_description`,`user_id`,`task_isHidden`) VALUES (:task_name,:task_description,:user_id,:task_isHidden)";
const SQL_INSERT_TASK_IMG="UPDATE `tasks` SET `task_img`=:task_img WHERE `task_id`=LAST_INSERT_ID()";
const SQL_UPDATE_TASK_WITHOUT_IMG="UPDATE `tasks` SET `task_name`=:task_name,`task_description`=:task_description,`task_isHidden`=:task_isHidden WHERE `task_id`=:task_id";
const SQL_UPDATE_TASK_IMG="UPDATE `tasks` SET `task_img`=:task_img WHERE `task_id`=:task_id";
const SQL_GET_TASKIMG_BY_TASKID="SELECT `task_img` FROM `tasks` WHERE `task_id`=:task_id";
function showError(string $errMessage){
	$errMsg=$errMessage;
	include "errors.php";
	exit();
}
?>
