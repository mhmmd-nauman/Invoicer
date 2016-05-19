<?php

	if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
	$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => 'root',
		"password" => '',
		"database" => str_replace('"',"", "db_emp")
	);
	} else {
		$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => str_replace('"',"","root"),
		"password" => str_replace('"',"","09polkmn"),
		"database" => str_replace('"',"", "invoiceddb")
	);
	}
	
	if(empty($databaseConfig['password']))$databaseConfig['password']="";
	$link  = mysqli_connect($databaseConfig['server'],trim($databaseConfig['username']),trim($databaseConfig['password']),trim($databaseConfig['database']));
       if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}
        else
            {
           //echo "connected";
        }
        //echo "ddd";
//exit;
$sql="SELECT * FROM `users`";
//$sql="UPDATE `users` SET `owner` = '0' WHERE  1";
//$sql="ALTER TABLE `users` CHANGE `owner` `owner` INT(11) NULL DEFAULT '0'; ;";
$result = $link->query($sql);
//exit;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
} else {
    echo "0 results";
}

$link->close();

?>

