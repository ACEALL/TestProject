<?php 
 session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('./Utilities.php');
	$util = new Utilities();
	require './DbModel.php';
	$db = new DbModel();
	list ($check, $data) = $util->check_login( $db, $_POST['email'], $_POST['pass']);
	if ($check) {
		$_SESSION["logged_in"]=true;
		$_SESSION["userid"]=$data["user_id"];
		$_SESSION["name"]=$data["first_name"];
		$_SESSION["level"]=$data["permission_level"];
		if($_SESSION["level"] == 2){
			$util->redirect_user('indexAdmin.php');	
		}
		$util->redirect_user('MainMenu.php');	
	} else { 
		$_SESSION["logged_in"]=false;
		$errors = $data;
	} 
} 
include ('includes/loginPage.php');
?>