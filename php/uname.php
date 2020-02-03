<?php

if($_COOKIE["authcode"]){
	$conn = initDB();

	$result = $connect->query("SELECT expiry, uID FROM authcodes WHERE code = ?", $_COOKIE["authcode"]);
 
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<br/>Expiry: " . $row["expiry"]. "<br/>uID: ". $row["uID"]."<br/><br/>";
			//TODO larger than or so
		//	if($row["expiry"] == date("Y-M-D H:i:s"){
				
		//	}
		}
	}
	else
		echo "No record found";
 
	$conn->close();
}

?>
