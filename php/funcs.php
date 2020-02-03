<?php

function initDB(){

	$dbpass = fopen("dbpass", "r") or die("Unable to open file!");

	$server="localhost";
	$username="website";
	$password=fread($dbpass, filesize("dpbass"));
	$database="website";

	fclose($dbpass);

	$conn=new mysqli($server,$username,$password,$database);

	if($connect->connect_error)
		echo $connect->connect_error;

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
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
	return implode('', $pieces);
}
?>
