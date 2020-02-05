<?php

include("funcs.php");

$authcode = random_str();
$exp = date("D M d Y H:i:s", strtotime(" + 10 days"));

//$servername = 'localhost';
//$username = 'website';
//$password = 'ycH*4|6KboGmKB';

try {
	$conn = initDB();

	//INSERT
	$stmt = $conn->prepare("INSERT INTO users (uname, pswd) VALUES (:uname, :pswd)");
	$stmt->bindParam(':uname', $uname);
	$stmt->bindParam(':pswd', $pswd);

	$uname = "hallo";
	$pswd = "kiiip";
	$stmt->execute();

	//SELECT
	$stmt = $conn->prepare("SELECT uID, uname, pswd FROM users WHERE uname = :uname AND pswd = :pswd");
	$stmt->bindParam(':uname', $uname);
	$stmt->bindParam(':pswd', $pswd);

	$uname = "drum";
	$pswd = "aaa";
		
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo $row['uID'] . ' ' . $row['uname'] . ' ' . $row['pswd'] . "\n";
	}		
}
catch(PDOException $e){
	echo "Connection failed: " . $e->getMessage();
}


$conn = null;
?>
