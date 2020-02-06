<?php

include("funcs.php");


if($_REQUEST["authcode"]){
	$conn = initDB();

	$stmt = $conn->prepare("SELECT expiry, uID FROM authcodes WHERE code = :code");
	$stmt->bindParam(':code', $_REQUEST["authcode"]);
	$stmt->execute();


	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<br/>Expiry: " . $row["expiry"]. "<br/>uID: ". $row["uID"]."<br/><br/>";
			//TODO larger than or so
		//	if($row["expiry"] == date("Y-M-D H:i:s"){
				
		//	}
	}

	$conn = null;
}

?>
