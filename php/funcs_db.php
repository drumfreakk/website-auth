<?php

function initDB(){

	$dbpass = fopen("./dbpass", "r");

	$server="localhost";
	$username="website";
	$password=fread($dbpass, filesize("./dbpass") - 1);
	$database="website";

	fclose($dbpass);

	$conn = null;
	$err = 0;

	try{
		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
		$conn = $e->getMessage();
		$err = 1;
	}

	return array("return"=>$conn, "status"=>$err);
}

?>
