<?php
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."SMP2/library/classes/dbConnCheck.Class.php");
if($_GET["func"]== "create") {
    $connection = new dbConnectionCheck();
    $connection->create_connection($_POST);
}elseif($_GET["func"] == "check") {
	if(file_exists(ROOT_FOLDER."SMP2/library/includes/connection.json")) {
		include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
		$connect = json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
		$connection = new dbConnectionCheck();
		$connection->check_connection($_POST);
	}else{
		echo "Connection file does not exist. Please enter the connection information and select `Save Connection`.";
	}
}
