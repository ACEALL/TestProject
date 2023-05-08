<?php 

function redirect_user ($page = '../index.php') {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;
	header("Location: $url");
	exit(); 

} 

function check_login($dbc, $email = '', $pass = '') {
	$errors = array(); 
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email = mysqli_real_escape_string($dbc, trim($email));
	}
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$password = mysqli_real_escape_string($dbc, trim($pass));
	}
	if (empty($errors)) { // If everything's OK.
		$query = "SELECT user_id, first_name, permission_level FROM users WHERE email='$email' AND pass=SHA1('$password')";		
		$run = @mysqli_query ($dbc, $query);
		if (mysqli_num_rows($run) == 1) {
			$row = mysqli_fetch_array ($run, MYSQLI_ASSOC);
			return array(true, $row);
			
		} else { 
			$errors[] = 'The email address and password entered do not match an existing user';
		}
		
	} 
	return array(false, $errors);
}