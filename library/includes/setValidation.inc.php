<?php
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
if($_POST["valType"]!== "initial"){
	$url = "'library/includes/dbUpdate.inc.php'";
}else{
	$url = "'library/includes/dbWrite.inc.php'";
}

if($_POST["valType"] == "full"){
	require_once(ROOT_FOLDER."/SMP2/library/includes/fullvalidation.inc.php");
}else{
	require_once(ROOT_FOLDER."/SMP2/library/includes/validation.inc.php");
}
