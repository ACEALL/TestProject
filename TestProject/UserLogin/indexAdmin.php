<?php
require ('includes/loginFunctions.php');
session_start();
if(!$_SESSION["logged_in"]) redirect_user('login.php');
$page_title = 'Welcome to the Admin Side';
include ('./includes/header.html');
?>
<h1>Welcome to the Admin Side</h1>
<h2>Admin Options</h2>

<?php
include ('../include/footer.html');
?>