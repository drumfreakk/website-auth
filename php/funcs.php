<?php

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
	if ($length < 1) {
		throw new \RangeException("Length must be a positive integer");
	}
	$pieces = [];
	$max = strlen($keyspace) - 1;
	for ($i = 0; $i < $length; ++$i) {
		$pieces []= $keyspace[random_int(0, $max)];
	}

	//$rStr = array("return"=>implode('', $pieces), "status"=>0);
	return implode('', $pieces);	
/*	
	die(implode('', $pieces));
	$db=initDB();
	if($db["status"] == 1){
		die($db["return"]);
	}
	$conn = $db["return"];

	$checkAuth = $conn->prepare("SELECT code FROM authcodes WHERE code = :code");
	$checkAuth->bindParam(':code', $rStr);
	$checkAuth->execute();

	while($row = $checkAuth->fetch(PDO::FETCH_ASSOC)){
		if($row['code'] == $rStr){
			if($depth >= 10){
				$rStr["status"] = 1;
				break;
			}
			$rStr = random_str($length, $keyspace, $depth + 1);
		}
	}
 */	
	return $rStr;
}

function insert($stmt, $exp, $authcode){
	try{
		$stmt->execute();
	}
	catch(PDOException $e){
		return 1;
	}
	return 0;
}

function insert_authcode(int $uid, $permissions){
	$status = 0;

	$db = initDB();
	if($db["status"] != 0){
		$status = 1;
	}
	$conn = $db["return"];

	$ins = $conn->prepare("INSERT INTO authcodes (uID, code, expiry, p_basic) VALUES (:uID, :code, :expiry, TRUE)");
	$ins->bindParam(":uID", $row['uID']);
	$ins->bindParam(":code", $authcode);
	$ins->bindParam(":expiry", $exp_unix);

	$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));
	$exp_unix = strtotime($exp);

	$authcode = random_str();

	$inserted = false;
	$count = 0;	

	while(!$inserted){
		if(insert($ins, strtotime($exp_unix), $authcode) == 1){
			$authcode = random_str();
			if($count >= 10){
				$inserted = true;
				$status = 1;
			}
		} else {
			$inserted = true;
		}
	}

	return array("status"=>$status, "authcode"=>$authcode, "expiry"=>$exp);
}

?>
