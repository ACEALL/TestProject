<?php
$page_title = ' Change Password';
include ('./includes/header.html');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('../mysqli_connect.php'); 
	$errors = array();
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$password = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}
	if (!empty($_POST['pass_1'])) {
		if ($_POST['pass_1'] != $_POST['pass_2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = mysqli_real_escape_string($dbc, trim($_POST['pass_1']));
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}
	
	if (empty($errors)) { 
		$query = "SELECT user_id FROM users WHERE (email='$email' AND pass=SHA1('$password') )";
		$run = @mysqli_query($dbc, $query);
		$num = @mysqli_num_rows($run);
		if ($num == 1) {
			$row = mysqli_fetch_array($run, MYSQLI_NUM);
			$query = "UPDATE users SET pass=SHA1('$np') WHERE user_id=$row[0]";		
			$run = @mysqli_query($dbc, $query);		
			if (mysqli_affected_rows($dbc) == 1) { 
				echo '<h1>Thank you!</h1>
				<p>Your password has been updated. Now you can log in!</p><p><br /></p>';	
			} else { 
				echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error.</p>'; 
				// Debug
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>';
	
			}

			mysqli_close($dbc); 
			include ('../include/footer.html'); 
			exit();
				
		} else { 
			echo '<h1>Error!</h1>
			<p class="error">The email address and password do not match those on file.</p>';
		}
		
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
<h1>Change Your Password</h1>
<form action="password.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	<p>Current Password: <input type="password" name="pass" size="10" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>"  /></p>
	<p>New Password: <input type="password" name="pass_1" size="10" maxlength="20" value="<?php if (isset($_POST['pass_1'])) echo $_POST['pass_1']; ?>"  /></p>
	<p>Confirm New Password: <input type="password" name="pass_2" size="10" maxlength="20" value="<?php if (isset($_POST['pass_2'])) echo $_POST['pass_2']; ?>"  /></p>
	<p><input type="submit" name="submit" value="Change Password" /></p>
</form>
<?php include ('../include/footer.html'); ?>