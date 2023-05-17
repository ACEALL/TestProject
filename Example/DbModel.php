<?php

class DbModel{
    public function __construct(){
        DEFINE ('DB_USER', 'root');
        DEFINE ('DB_PASSWORD', 'root');
        DEFINE ('DB_HOST', 'localhost');
        DEFINE ('DB_NAME', 'yahtzee');
        $this->dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
        mysqli_set_charset($this->dbc, 'utf8');
    }

    public function returnUserCount(){
        $query = 'SELECT COUNT(user_id) FROM users';
        $run = @mysqli_query ($this->dbc, $query);
        $row = @mysqli_fetch_array ($run, MYSQLI_NUM);
        $records = $row[0];
        mysqli_free_result ($run);
        return $records;
    }
    
    public function returnListofUsers($order_by, $start, $display){
        $rows = [];
        $query = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY $order_by LIMIT $start, $display";		
        $run = @mysqli_query ($this->dbc, $query); 
        while ($row = mysqli_fetch_array($run, MYSQLI_ASSOC)) {
            array_push($rows,$row);
        }
        mysqli_free_result ($run);
        return $rows;
    }

    public function insertUsers($firstName,$lastName,$email,$password){
        $fn = mysqli_real_escape_string($this->dbc, trim($firstName));
        $ln = mysqli_real_escape_string($this->dbc, trim($lastName));
        $ema = mysqli_real_escape_string($this->dbc, trim($email));
        $pass = mysqli_real_escape_string($this->dbc, trim($password));
        $query = "INSERT INTO users (first_name, last_name, email, pass, permission_level, registration_date) VALUES ('$fn', '$ln', '$ema', SHA1('$pass'), 1,  NOW() )";		
		$run = @mysqli_query ($this->dbc, $query); 
        return $run ? $run : mysqli_error($this->dbc);
    }

    public function loginValidate($email, $password){
        $ema = mysqli_real_escape_string($this->dbc, trim($email));
        $pass = mysqli_real_escape_string($this->dbc, trim($password));
        $query = "SELECT user_id, first_name, permission_level FROM users WHERE email='$ema' AND pass=SHA1('$pass')";		
		$run = @mysqli_query ($this->dbc, $query);
		if (mysqli_num_rows($run) == 1) {
			$row = mysqli_fetch_array ($run, MYSQLI_ASSOC);
			return array(true, $row);
        }else { 
        $errors[] = 'The email address and password entered do not match an existing user';
         } 
        return array(false, $errors);
    }
    public function updateUser($np, $row){
            $pass = mysqli_real_escape_string($this->dbc, trim($np));
            $query = "UPDATE users SET pass=SHA1('$pass') WHERE user_id=$row";		
			$run = @mysqli_query($this->dbc, $query);		
			if (mysqli_affected_rows($this->dbc) == 1) { 
                return true;
            }else{
                mysqli_error($this->dbc);
            }
    }
    public function closeDB(){
        mysqli_close($this->dbc); 
    }


 
}