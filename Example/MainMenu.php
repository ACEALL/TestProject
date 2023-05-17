<?php 
session_start();
$page_title = 'Main Menu';
include ('./include/header.html');
echo'
<body onload = "hide()" >
<div id=menu-container class="menu-container">
<h1>Welcome to Yahtzee</h1>
<p>Please choose one of the following options:</p>
<ul class="options-list">
    <li><button onclick="showAdditionalForm()">Play Game</button></li>
    <li><button>Read Rules</button></li>
    <li><button>Quit</button></li>
</ul>
</div>';
echo'';
if($_SESSION["logged_in"]==true){
echo '<div id="additionalForm" class="additional-form">
<p>Please select an option:</p>
<button>Start Game</button>
<button>Quit</button>
</div>';}
else{
echo'<div id="additionalForm" class="additional-form">
<p>Please select an option:</p>
<button>Create an Account</button>
<a href="./loginPage.php">Login</a>
<button>Quit</button>
</div>';
}
?>
<script>
    function hide(){
        var form = document.getElementById("additionalForm");
        form.style.display = "none";

    }
    function showAdditionalForm() {
        var form = document.getElementById("additionalForm");
        form.style.display = "block";
        var form2 = document.getElementById("menu-container");
        form2.style.display = "none";
    }
</script>