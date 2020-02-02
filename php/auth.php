<?php
include("funcs.php");
if($_REQUEST["uname"] && $_REQUEST["pswd"]){
//TODO add database link
//	echo $_REQUEST["uname"];
//	echo $_REQUEST["pswd"];
}
echo date("D M d Y H:i:s", strtotime(" + 10 days"));
echo " GMT+0100 (Central European Standard Time)&";
echo random_str();
?>
