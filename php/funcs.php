<?php

function initDB(){

	$dbpass = fopen("dbpass", "r") or die("Unable to open file!");

	$server="localhost";
	$username="website";
	$password=fread($dbpass, filesize("dbpass"));//"ycH*4|6KboGmKB";//fread($dbpass, filesize("dbpass"));
	$database="website";

	fclose($dbpass);

	try{
		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}

	return $conn;
}

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = strlen($keyspace) - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
	return implode('', $pieces);
}
?>
