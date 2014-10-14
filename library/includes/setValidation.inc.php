<?php
if(empty($_SESSION["sessionId"])){
	session_start();
}
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
if($_POST["valType"]!== "initial"){
	$url = "'library/includes/dbUpdate.inc.php'";
}else{
	$_SESSION["sampleStatus"]= "New";
	$url = "'library/includes/dbWrite.inc.php'";
	if(!in_array(ROOT_FOLDER."/SMP2/library/includes/validation.inc.php", get_included_files())){
		require_once(ROOT_FOLDER."/SMP2/library/includes/validation.inc.php");
	}

}

if($_SESSION["sampleStatus"] == "Results Received") {
	if(!in_array(ROOT_FOLDER."/SMP2/library/includes/fullvalidation.inc.php", get_included_files())){
		require_once(ROOT_FOLDER."/SMP2/library/includes/fullvalidation.inc.php");
	}
}

var_dump(get_included_files());