<?php

include_once("funcs_db.php");
include_once("funcs_err.php");

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

function checkAuth($authcode){
	$db=initDB();
	if($db["status"] == 1){
		echoError("Server error, please try again.", 1);		
	}

	$conn = $db["return"];

	$stmt = $conn->prepare("SELECT uID, permissions, expiry, codeId FROM authcodes WHERE code = :code");
	$stmt->bindParam(':code', $authcode);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($row['uID'] == NULL){
		echoError("It seems you have been logged out...", 1);
		return array("status"=>1);
	}

	if($row['expiry'] <= time()){
		$del = $conn->prepare("DELETE FROM authcodes WHERE codeId = :codeId");
		$del->bindParam(':codeId', $row['codeId']);
		$del->execute();
		
		echoError("Too late", 2);
		return array("status"=>2);
	}
	
	return array("status"=>0, "uID"=>$row['uID'], "permissions"=>json_decode($row['permissions'], false));	
}

?>
