<?php 
require ('includes/loginFunctions.php');
session_start();
$page_title = 'Logged In!';
if(!$_SESSION["logged_in"]) redirect_user('login.php');	
include ('./includes/header.html');
echo "<h1>Logged In!</h1>
<p>$_SESSION[name] is now logged in!</p>
<p><a href=\"logout.php\">Logout</a></p>";
include ('../include/footer.html');
?>