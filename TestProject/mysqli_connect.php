<?php 

// Set the database access information
//set username that is on your local mysql setup
DEFINE ('DB_USER', 'root');
//change to what password you are using. This should be obfucated in a env file that is hidden but for our purpose it will work
DEFINE ('DB_PASSWORD', 'root');
DEFINE ('DB_HOST', 'localhost');
// have to make sure DB is set on your local system 
DEFINE ('DB_NAME', 'yahtzee');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');