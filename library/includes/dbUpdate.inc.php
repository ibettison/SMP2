<?php
if(session_id() == ''){
	session_start();
}
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
$connect = json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
    die("Cannot connect to the database");
}

include                 (ROOT_FOLDER."SMP2/library/classes/makeXMLFile.Class.php");
include                 (ROOT_FOLDER."SMP2/library/classes/makeArchivedXMLFile.Class.php");
include                 (ROOT_FOLDER."SMP2/library/classes/dbWrite.Class.php");
include                 (ROOT_FOLDER."SMP2/library/classes/dbUpdate.Class.php");

//lets check to see if the user has tried to change any of the key fields.
// the user must delete and recreate the sample if this is the case
try{
	if($_SESSION["fieldValues"]["localPatientIdentifier"] !== $_POST["localPatientIdentifier"]) {
		throw new Exception("The Patient Identifier cannot be changed. Please delete this sample and recreate it and inform the TH of the change ASAP.");
	}
	if($_SESSION["fieldValues"]["organisationCode"] !== $_POST["organisationCode"]) {
		throw new Exception("The Organisation Code cannot be changed. Please delete this sample and recreate it and inform the TH of the change ASAP.");
	}
	if($_SESSION["fieldValues"]["sourceSampleIdentifier"] !== $_POST["sourceSampleIdentifier"]) {
		throw new Exception("The sample ID cannot be changed. Please delete this sample and recreate it and inform the TH of the change ASAP.");
	}
	if($_SESSION["sampleStatus"] == "Ready to Archive" or $_SESSION["sampleStatus"] == "Archived"){
		throw new Exception("The status of this record `".$_SESSION["sampleStatus"]."` does not allow further editing.");
	}
}catch(Exception $exception){
	die($exception->getMessage());
}

//list of file details for table smp2_hub
$hubFieldNames          = array("h_id", "hubName");
$hubTable               = "smp2_hub";
$hubLink                = null;
$hubCheck               = "hubName";
$updateTables			= array("FieldValue"=>$_SESSION["fieldValues"][$hubCheck]);
$writeTables            = new dbUpdate($hubFieldNames, $hubTable, $hubLink, $hubCheck, $updateTables);

//list of file details for table smp2_patients
$hubTableLink           = $writeTables->get_index(); //this gets the index info from the Hub table
$patientFieldNames      = array("p_id","h_id","organisationCode","localPatientIdentifier","treatingOncologistInitials",
								"ageAtAttendance","genderCode","ethnicCategory","smokingStatus","noOfPriorLinesTherapy","cancerTreatmentModality",
								"performanceStatus");
$patientTable           = "smp2_patients";
$patientCheck           = "localPatientIdentifier";
$updateTables			= array("FieldValue"=>$_SESSION["fieldValues"][$patientCheck]);
$writeTables            = new dbUpdate($patientFieldNames, $patientTable, $hubTableLink, $patientCheck, $updateTables);

//list of file details for table smp2_samples
$patientTableLink       = $writeTables->get_index(); //this gets the index info from the Patients table

$samplesFieldNames      = array("s_id","sourceSampleIdentifier","originOfSample","typeOfSample","procedureToObtainSample", "typeOfBiopsy","dateSampleTaken",
								"morphologySnomed","tumourType","pathologyTCategory","pathologyNCategory","pathologyMCategory",
								"integratedTNMStageGrouping","alkStatus","egfrStatus","alkFishStatus","krasStatus","dateSampleSent");
$samplesTable           = "smp2_samples";
$samplesCheck           = "sourceSampleIdentifier";
$updateTables			= array("FieldValue"=>$_SESSION["fieldValues"][$samplesCheck]);
$writeTables            = new dbUpdate($samplesFieldNames, $samplesTable, null, $samplesCheck, $updateTables);
$sampleTableLink        = $writeTables->get_index();


if($writeTables->get_dataWritten()) { //has the samples data table been written to?
    //now lets create the XML File
	if(!isset($writeTables->statusChange)){
		$makeXML = new makeXML();
		$makeXML->makeXMLFile($patientTableLink["id"], $sampleTableLink["id"]);
	}elseif($writeTables->statusChange){
		$makeXML = new makeArchiveXML();
		$makeXML->makeXMLFile($patientTableLink["id"], $sampleTableLink["id"]);
	}

}
dl::closedb();