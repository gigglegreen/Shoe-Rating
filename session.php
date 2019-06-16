<?php
	session_start();

	if(!isset($_SESSION['login_user'])){
		header("location:login.php");
	}
	$name = $_SESSION['login_name'];



?>

