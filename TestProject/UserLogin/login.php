<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('includes/loginFunctions.php');
	require ('../mysqli_connect.php');
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);
	if ($check) {
		//add Session
		redirect_user('loggedin.php');	
	} else { 
		$errors = $data;
	}
	mysqli_close($dbc); 
} 
include ('includes/loginPage.php');
?>