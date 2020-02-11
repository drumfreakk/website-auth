<?php

include("funcs.php");


function checkAuth($authcode){
	$db=initDB();
	if($db["status"] == 1){
		echoError("Server error, please try again.", 1);		
	}

	$conn = $db["return"];

	$stmt = $conn->prepare("SELECT uID, permissions, expiry FROM authcodes WHERE code = :code");
	$stmt->bindParam(':code', $authcode);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$conn = null;

	if($row['uID'] == NULL){
		return array("status"=>1, "error"=>"It seems you have been logged out...");
	}

	if($row['expiry'] <= time()){
	

		return array("status"=>2, "error"=>"Too late");
	}
	
	return array("status"=>0, "uID"=>$row['uID'], "permissions"=>json_decode($row['permissions'], false));	
}


if($_REQUEST["authcode"]){

	var_dump(checkAuth($_REQUEST["authcode"]));
/*
	$db=initDB();
	if($db["status"] == 1){
		die($db["return"]);
	}
	$conn = $db["return"];

	$stmt = $conn->prepare("SELECT uID FROM authcodes WHERE code = :code");
	$stmt->bindParam(':code', $_REQUEST["authcode"]);
	$stmt->execute();


	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$usr = $conn->prepare("SELECT username FROM users WHERE uID = :uid");
		$usr->bindParam(':uid', $row["uID"]);
		$usr->execute();
		while($unm = $usr->fetch(PDO::FETCH_ASSOC)){
			$status = 0;
			echo '{"username":"'.$unm["username"].'","status":'.$status.'}';
		}

		//echo "<br/>Expiry: " . $row["expiry"]. "<br/>uID: ". $row["uID"]."<br/><br/>";
		//	if($row["expiry"] == date("Y-M-D H:i:s"){
				
		//	}
	}

	$conn = null;
*/
}

?>
