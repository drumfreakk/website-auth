<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/js/auth.js"></script>	

</head>
<body>

<?php

require_once("php/funcs_req.php");

if(!isset($_COOKIE["authcode"])){
	?>
	<form id="content" action="javascript:submitCreds();">
		Username:<input type="text" id="username">
		</br>
		Password:<input type="password" id="password">
		</br>
		<input type="submit" value="submit">
	</form>	
	<div id="comment"></div>

	<?php
} else {
	
	$req = json_decode(post_request("http://192.168.2.7/php/uname.php", array("authcode"=>$_COOKIE["authcode"])));

	if($req->status == 0){
		echo "Welcome, ".$req->response;
	} else {
		echo $req->error;
		if($req->status == 1){
			setcookie("authcode", "", time() - 3600);
		}
	}	
}
?>



</body>
</html>
