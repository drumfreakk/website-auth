<?php

include("funcs.php");


if($_REQUEST["authcode"]){
	$conn = initDB();

	$stmt = $conn->prepare("SELECT uID FROM authcodes WHERE code = :code");
	$stmt->bindParam(':code', $_REQUEST["authcode"]);
	$stmt->execute();


	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$usr = $conn->prepare("SELECT username FROM users WHERE uID = :uid");
		$usr->bindParam(':uid', $row["uID"]);
		$usr->execute();
		while($unm = $usr->fetch(PDO::FETCH_ASSOC)){
			echo $unm["username"];
		}

		//echo "<br/>Expiry: " . $row["expiry"]. "<br/>uID: ". $row["uID"]."<br/><br/>";
		//	if($row["expiry"] == date("Y-M-D H:i:s"){
				
		//	}
	}

	$conn = null;
}

?>
