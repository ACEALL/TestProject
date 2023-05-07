<?php 
$page_title = 'Registraton';
include ('./includes/header.html');

// Check form this can be done by javascript to ensure regex and sql injection protection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('../mysqli_connect.php');
	$errors = array(); 
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$firstName = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$lastName = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	if (!empty($_POST['pass_1'])) {
		if ($_POST['pass_1'] != $_POST['pass_2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$password = mysqli_real_escape_string($dbc, trim($_POST['pass_1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	if (empty($errors)) { 
		// Register the user in the database
		$query = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES ('$firstName', '$lastName', '$email', SHA1('$password'), NOW() )";		
		$run = @mysqli_query ($dbc, $query); 
		if ($run) { 
			echo '<p>You are now registered</p>';	
		
		} else {	
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error</p>'; 
			
			// Debug
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>';				
		} 
		
		mysqli_close($dbc); // Close DB

		include ('../include/footer.html'); 
		exit();
		
	} else { 
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} 
	
	mysqli_close($dbc); 

}
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	<p>Password: <input type="password" name="pass_1" size="10" maxlength="20" value="<?php if (isset($_POST['pass_1'])) echo $_POST['pass_1']; ?>"  /></p>
	<p>Confirm Password: <input type="password" name="pass_2" size="10" maxlength="20" value="<?php if (isset($_POST['pass_2'])) echo $_POST['pass_2']; ?>"  /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
<?php include ('../include/footer.html'); ?>