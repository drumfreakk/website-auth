<?php

include_once("funcs_auth.php");

if($_REQUEST["authcode"]){

	$auth = checkAuth($_REQUEST["authcode"]);

	if($auth['status'] != 0){
		exit();	
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
