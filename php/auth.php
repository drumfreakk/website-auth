<?php

include("funcs.php");

if($_REQUEST["username"] && $_REQUEST["password"]){
	
	$authcode = random_str();
	$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));

	$conn=initDB();
	
	//TODO hash password
	$stmt=$conn->prepare("SELECT uID, password FROM users WHERE username = :username");
	$stmt->bindParam(':username', $username);

	$username = $_REQUEST["username"];
	$stmt->execute();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		if(password_verify($_REQUEST["password"], $row['password'])){	
	
			$ins = $conn->prepare("INSERT INTO authcodes (uID, code, expiry) VALUES (:uID, :code, :expiry)");
			$ins->bindParam(":uID", $row['uID']);
			$ins->bindParam(":code", $authcode);
			$ins->bindParam(":expiry", $exp_unix);

			$exp_unix = strtotime($exp);
			$ins->execute();

			echo $authcode . "&" . $exp . " GMT+0100 (Central European Standard Time)";
		}
	}
	$conn = null;
}
?>
