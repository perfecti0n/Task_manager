<?php
session_start();
unset($_COOKIE['email']);
unset($_COOKIE['password']);
setcookie('email', null, -1, '/');
setcookie('password', null, -1, '/');
session_unset();
header("Location: login-form.php");
?>