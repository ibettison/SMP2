<?php
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
$root = $_SERVER["DOCUMENT_ROOT"];
define("ROOT_FOLDER", $root);
}

require_once(ROOT_FOLDER."SMP2/library/includes/sendSFTP.inc.php");
require_once(ROOT_FOLDER."SMP2/library/classes/sendSamples.Class.php");
require_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");

$connect = json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}

if(empty($_POST)){ //if there is no post then this must be a cron job execution
	$sql = "select sourceSampleIdentifier, samples_id from smp2_samples left outer join smp2_status on (s_id=samples_id) where samples_id is NULL";
	$notSent = dl::getQuery($sql);
	try{
		if(empty($notSent)) {
			throw new Exception("There is nothing to send");
		}else{
			foreach ($notSent as $toBeSent) {
				$notSentList[] = $toBeSent["sourceSampleIdentifier"];
			}
			$send = new sendSamples( array("sampleArray"=>$notSentList ));
		}
	}catch(Exception $exception){
		die($exception->getMessage());
	}
}else{
	$send = new sendSamples( $_POST );
}
$send->sendFileNames();
dl::closedb();