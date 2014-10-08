<?php
if(session_id() == ''){
	session_start();
}
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect = json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
    die("Cannot connect to the database");
}

include                 (ROOT_FOLDER."/SMP2/library/classes/makeXMLFile.Class.php");
include                 (ROOT_FOLDER."/SMP2/library/classes/dbWrite.Class.php");

//list of file details for table smp2_hub
$hubFieldNames          = array("h_id", "hubName");
$hubTable               = "smp2_hub";
$hubLink                = null;
$hubCheck               = "hubName";
$writeTables            = new dbWrite($hubFieldNames, $hubTable, $hubLink, $hubCheck);

//list of file details for table smp2_patients
$hubTableLink           = $writeTables->get_index(); //this gets the index info from the Hub table
$patientFieldNames      = array("p_id","h_id","organisationCode","localPatientIdentifier","treatingOncologistInitials",
"ageAtAttendance","genderCode","ethnicCategory","smokingStatus","noOfPriorLinesTherapy","cancerTreatmentModality",
"performanceStatus");
$patientTable           = "smp2_patients";
$patientCheck           = "localPatientIdentifier";
$writeTables            = new dbWrite($patientFieldNames, $patientTable, $hubTableLink, $patientCheck);

//list of file details for table smp2_samples
$patientTableLink       = $writeTables->get_index(); //this gets the index info from the Patients table
$samplesFieldNames      = array("s_id","sourceSampleIdentifier","originOfSample","typeOfSample","procedureToObtainSample", "typeOfBiopsy","dateSampleTaken",
"morphologySnomed","tumourType","pathologyTCategory","pathologyNCategory","pathologyMCategory",
"integratedTNMStageGrouping","alkStatus","egfrStatus","alkFishStatus","krasStatus","dateSampleSent");
$samplesTable           = "smp2_samples";
$samplesCheck           = "sourceSampleIdentifier";
$writeTables            = new dbWrite($samplesFieldNames, $samplesTable, null, $samplesCheck);
$sampleTableLink        = $writeTables->get_index();

//create the link between the sample table and the patient table
// this is needed as there may be multiple samples from a patient if there are multiple cancers.
$createLink = new dbCreateLink($patientTableLink, $sampleTableLink, "smp2_patient_samples", array("patients_id", "samples_id"));

if($writeTables->get_dataWritten()) { //has the samples data table been written to?
    //now lets create the XML File
    makeXML::makeXMLFile($patientTableLink["id"], $sampleTableLink["id"]);
}
dl::closedb();

