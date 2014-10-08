<?php
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect 				= json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn 				= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}

include                 (ROOT_FOLDER."/SMP2/library/classes/sampleStatus.Class.php");
$statusCheck			= new sampleStatus($_POST["sampleID"]);
$status					= $statusCheck->get_status();