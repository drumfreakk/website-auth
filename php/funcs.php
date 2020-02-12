<?php

function echoError($error, $code){
	echo '{"status":'.$code.', "error":"'.$error.'"}';
}

function initDB(){

	$dbpass = fopen("./dbpass", "r") or die("Unable to open file!");

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

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
){
//	return "abcdefg";
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

function insert($stmt){
	try{
		$stmt->execute();
	}
	catch(PDOException $e){
		die($e);
		return 1;
	}
	return 0;
}

function insert_authcode($uid, $permissions = '{"basic":true}'){
	$status = 0;
	
	$db = initDB();
	if($db["status"] != 0){
		$status = 1;
	}
	$conn = $db["return"];

	$ins = $conn->prepare("INSERT INTO authcodes (uID, code, expiry, permissions) VALUES (:uID, :code, :expiry, :permissions)");
	$ins->bindParam(":uID", $uid);
	$ins->bindParam(":code", $authcode);
	$ins->bindParam(":expiry", $exp);
	$ins->bindParam(":permissions", $permissions);
	
	$exp = strtotime("+ 10 days");

	$authcode = random_str();

	$inserted = false;
	$count = 0;	

	while(!$inserted){
		if(insert($ins) == 1){
			$authcode = random_str();
			if($count >= 10){
				$conn = null;
				return array("status"=>1, "error"=>"Failed logging in");
			}
			$count = $count + 1;
		} else {
			$inserted = true;
		}
	}
	$conn = null;
	return array("status"=>$status, "authcode"=>$authcode, "expiry"=>$exp);
}

?>
