<?php

include("funcs.php");

if($_REQUEST["username"] && $_REQUEST["password"]){
	
	$authcode = random_str();
	$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));

	$conn=initDB();
	
	//TODO hash password
	$stmt=$conn->prepare("SELECT uID FROM users WHERE username = :username AND password = :password");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);

	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$stmt->execute();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$ins = $conn->prepare("INSERT INTO authcodes (uID, code, expiry) VALUES (:uID, :code, :expiry)");
		$ins->bindParam(":uID", $row['uID']);
		$ins->bindParam(":code", $authcode);
		$ins->bindParam(":expiry", $exp_unix);

		$exp_unix = strtotime($exp);
		$ins->execute();

		echo $authcode . "&" . $exp . " GMT+0100 (Central European Standard Time)";
	}
	$conn = null;
}
?>
