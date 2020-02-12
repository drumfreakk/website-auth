<?php

include("funcs.php");

if($_REQUEST["username"] && $_REQUEST["password"]){
	
	$db=initDB();
	if($db["status"] == 1){
		echoError("Server error, please try again later", 1);
	}
	$conn = $db["return"];
	
	$stmt=$conn->prepare("SELECT uID, password FROM users WHERE username = :username");
	$stmt->bindParam(':username', $username);

	$username = $_REQUEST["username"];
	$stmt->execute();
	

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(password_verify($_REQUEST["password"], $row['password'])){	
	
		$ins_authcode = insert_authcode($row['uID']);
		if($ins_authcode["status"] != 0){
			echoError($ins_authcode['error'], $ins_authcode['status']);
		}else{
			$str = array("authcode"=>$ins_authcode['authcode'], "expiry"=>$ins_authcode['expiry'], "status"=>0);
			echo json_encode($str); 
		}
	}
	else {
		echoError("Incorrect username or password, please try again", 2);
	}	
	$conn = null;
}
?>
