<?php 
 session_start();
$page_title = 'Logged Out!';
include ('./includes/header.html');
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";
$_SESSION["logged_in"]=false;
unset($_SESSION["userid"]);
unset($_SESSION["name"]);
unset($_SESSION["level"]);
include ('../include/footer.html');
?>