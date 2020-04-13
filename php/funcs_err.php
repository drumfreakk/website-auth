<?php

function echoError($error, $code){
	echo '{"status":'.$code.', "error":"'.$error.'"}';
}

?>
