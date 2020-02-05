<?php

include("funcs.php");

if($_REQUEST["username"] && $_REQUEST["password"]){

	$authcode = random_str();
	$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));

	$conn=initDB();
	//TODO hash password
	$stmt=$conn->prepare("SELECT uID FROM users WHERE username = ? AND password = ?");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo $row['uID'] . "&HELLO";
	}
//	if($res->num_rows > 0){
//		while($row = $res->fetch_assoc()){
//			$ins = $conn->query("INSERT INTO authcodes (uID, code, expiry) VALUES (?, ?, ?)", $row["uID"], $authcode, strtotime($exp));	
//			echo $exp;
//			echo " GMT+0100 (Central European Standard Time)&";
//			echo $authcode;
//		}
//	} else {
//		echo "Ye&this dont work";
//	}
	
	$conn = null;
}
?>
