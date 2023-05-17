<?php 
class Utilities{
function redirect_user ($page = '../index.php') {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;
	header("Location: $url");
	exit(); 

} 
function sendHome () {
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	$url = rtrim($url, '/\\');
	$url .=  '/TestProject/index.php';
	header("Location: $url");
	exit(); 

} 
function check_login( $db, $email = '', $pass = '') {
	$errors = array(); 
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email =trim($email);
	}
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$password = trim($pass);
	}
	if (empty($errors)) { // If everything's OK.
		$login = $db->loginValidate($email,$pass);
		//$db->closeDB();
		return $login;
}
}
}