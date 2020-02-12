<?php

include("funcs.php");


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
		return array("status"=>1, "error"=>"It seems you have been logged out...");
	}

	if($row['expiry'] <= time()){
		$del = $conn->prepare("DELETE FROM authcodes WHERE codeId = :codeId");
		$del->bindParam(':codeId', $row['codeId']);
		$del->execute();

		return array("status"=>2, "error"=>"Too late");
	}
	
	return array("status"=>0, "uID"=>$row['uID'], "permissions"=>json_decode($row['permissions'], false));	
}


if($_REQUEST["authcode"]){

	$auth = checkAuth($_REQUEST["authcode"]);

	if($auth['status'] != 0){
		echo json_encode($auth);
	} else {
		if($auth['permissions']->basic == true){

			$db=initDB();
			if($db["status"] == 1){
				echoError("Server error, please try again.", 1);		
				exit();
			}

			$conn = $db["return"];
		
			$stmt = $conn->prepare("SELECT username FROM users WHERE uID = :uid");
			$stmt->bindParam(':uid', $auth['uID']);
			$stmt->execute(); 

			echo json_encode(array("status"=>0, "response"=>$stmt->fetch(PDO::FETCH_ASSOC)['username']));
		} else {
			echoError("Incorrect permissions", 1);
		}
	}

}

?>
