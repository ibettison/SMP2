<?php
if(!defined("ROOT_FOLDER")){
	$root 		= $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
$connect 		= json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
if(!$conn 		= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
if($_POST["sampleArray"] !== "New"){
	$statusID 		= dl::select("smp2_samples", "sourceSampleIdentifier = '".$_POST["sampleArray"][0]."'");
	$status 		= dl::select("smp2_status", "samples_id = ".$statusID[0]["s_id"] );
	if(empty($status)){
		echo '[{"status":"Not Sent"}]';
	}else{
		echo json_encode($status);
	}
}else{
	echo '[{"status":"New"}]';
}

