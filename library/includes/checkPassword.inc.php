<?php
session_start();
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect 						= json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn 						= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
$security_settings 				= dl::select("smp2_security");
$hashed_password = crypt($_POST["check"], "$2a$11$".bin2hex($security_settings[0]["sec_salt"]));
if($hashed_password == $security_settings[0]["sec_password"]){
	$_SESSION["LOGGED_IN"]=true;
	echo "Successful Login";
}else{
	echo "Incorrect Password entered.";
}
