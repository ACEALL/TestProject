<?php 
 session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('includes/loginFunctions.php');
	require ('../mysqli_connect.php');
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);
	if ($check) {
		$_SESSION["logged_in"]=true;
		$_SESSION["userid"]=$data["user_id"];
		$_SESSION["name"]=$data["first_name"];
		$_SESSION["level"]=$data["permission_level"];
		if($_SESSION["level"] == 2){
			redirect_user('indexAdmin.php');	
		}
		redirect_user('loggedin.php');	
	} else { 
		$_SESSION["logged_in"]=false;
		$errors = $data;
	}
	mysqli_close($dbc); 
} 
include ('includes/loginPage.php');
?>