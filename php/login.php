<?php
$errormsg = "";

if($_POST["username"] && $_POST["password"]){
	echo htmlspecialchars($_POST["username"]);
	echo htmlspecialchars($_POST["password"]);

}else{
	$errormsg = "Missing username and/or password";
}

if($errormsg != ""){
	echo($errormsg);
	echo("</br><a href='/index.html'>Go back</a>");
}
?>
