<?php
if(!defined("ROOT_FOLDER")){
$root = $_SERVER["DOCUMENT_ROOT"];
define('ROOT_FOLDER', $root);
}
require_once(ROOT_FOLDER."SMP2/library/includes/sendSFTP.inc.php");
require_once(ROOT_FOLDER."SMP2/library/classes/checkForResults.Class.php");
include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
$connect = json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
try{
	if(!$ftpConnect 	= sftpConnect::connectionVariables()) {
		throw new Exception("Cannot connect to .json connection file to capture the variables.");
	}
	$results 			= new checkResults();
	$resultsFolder 		= $ftpConnect["resultFolder"];
	$resultNames 		= $results->findResults($resultsFolder);
	$folder_location 	= $results->downloadFiles(ROOT_FOLDER."/SMP2/xml-documents/files-received/");
	$recordArray 		= $results->findRecords($resultNames);
	if($results->writeRecords()){
		echo "Results have been received and the data extracted and saved.";
	}else{
		echo "The results have already been written to the database.";
	}
}catch(Exception $exception){
	die($exception->getMessage());
}



