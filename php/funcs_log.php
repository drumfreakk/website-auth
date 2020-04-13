<?php

function web_log($toLog, $location){
	$lognts = date("[D d-m-Y H:i:s]: ") . $location . " says: " . $toLog;
	file_put_contents("log", $lognts.PHP_EOL, FILE_APPEND | LOCK_EX);
}	

?>
