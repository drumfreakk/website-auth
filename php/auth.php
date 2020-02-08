<?php

include("funcs.php");

if($_REQUEST["username"] && $_REQUEST["password"]){
	
	$db=initDB();
	if($db["status"] == 1){
		die($db["return"]);
	}
	$conn = $db["return"];
	
	$stmt=$conn->prepare("SELECT uID, password FROM users WHERE username = :username");
	$stmt->bindParam(':username', $username);

	$username = $_REQUEST["username"];
	$stmt->execute();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		if(password_verify($_REQUEST["password"], $row['password'])){	
	
			/*$ins = $conn->prepare("INSERT INTO authcodes (uID, code, expiry, p_basic) VALUES (:uID, :code, :expiry, TRUE)");
			$ins->bindParam(":uID", $row['uID']);
			$ins->bindParam(":code", $authcode);
			$ins->bindParam(":expiry", $exp_unix);

			$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));

			$auth = random_str();
			$authcode = $auth["return"];
			if($auth["status"] != 0){
				echo "Fuck";
			}

			$exp_unix = strtotime($exp);
			$ins->execute();
*/
			$ins_authcode = insert_authcode($row['uID'], 0);
			if($ins_authcode != 0){
				echo "Fuck";
			}

			echo $ins_authcode['authcode'] . "&" . $ins_authcode['expiry'] . " GMT+0100 (Central European Standard Time)";
		}
	}
	$conn = null;
}
?>
