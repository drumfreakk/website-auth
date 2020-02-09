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
	
			$ins_authcode = insert_authcode($row['uID'], 0);
			if($ins_authcode["status"] != 0){
				echo "Fuck";
			}

			echo $ins_authcode['authcode'] . "&" . $ins_authcode['expiry'] . " GMT+0100 (Central European Standard Time)";
		}
	}
	$conn = null;
}
?>
