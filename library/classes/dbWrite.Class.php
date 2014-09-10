<?php
/**
 * Created by PhpStorm.
 * User: nib8
 * Date: 02/09/14
 * Time: 15:03
 */

//link to database access class and connection
include                 ("../mysqli_datalayer.php");
include                 ("../connection.php");
include                 ("makeXMLFile.Class.php");

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

//now lets create the XML File
makeXML::makeXMLFile($patientTableLink["id"]);



class dbWrite {
    public $table_link;
    function __construct( $fields, $table, $link, $existingRecordCheck ){
        $this->write_data($fields, $table, $link, $existingRecordCheck);
    }

    function write_data ( $fieldArray, $table, $link, $check ) {
        //set debug to true to monitor SQL Statements
        //dl::$debug = true;

        //take the first element off of the array as this is the index.
        $index                                  = array_shift($fieldArray);
        foreach($fieldArray as $field) {
            //the field may not be in the POST array as it is an optional field so lets check for the key

            if(array_key_exists($field, $_POST)){
                //check if the key is an array
                if(is_array($_POST[$field])){
                    $listOfTreatmentTypes       = "";
                    foreach($_POST[$field] as $val) {
                        //create comma delimited list of the select values contained in the array
                        $listOfTreatmentTypes  .= substr($val,0,2).",";
                    }
                    $listOfTreatmentTypes       = substr($listOfTreatmentTypes,0,strlen($listOfTreatmentTypes)-1);
                    $values[]                   = $listOfTreatmentTypes;
                }else{
                    $values[]                   = $_POST[$field];
                }
            }else{
                //check here if need to create a link to the linked table
                if($field == $link["indexField"]) {
                    $values[] = $link["id"];
                }else{
                    $values[]                   = "";
                }
            }

        }
        $writeLn                                = array_combine($fieldArray, $values);
        $quotes = "";
        if(gettype($check)                      == "string") {
            $quotes = "'";
        }
        $checkRecordExists                      = dl::select($table,$check."=".$quotes.$_POST[$check].$quotes);
        if(empty($checkRecordExists)){
            dl::insert($table, $writeLn);
            //capture the index id created after the write to the table
            $lastId                             = dl::getId();
            $this->set_index($table, $index, $lastId);
        }else{
            echo $table." - record was not updated as the data already exists.<BR>";
            $lastId                             = $checkRecordExists[0][$index];
            $this->set_index($table, $index, $lastId);
        }

    }


    function set_index ($table, $index, $id) {
        $this->table_link                       = array("tableName"=>$table, "indexField"=>$index, "id"=>$id);
    }

    function get_index() {
        return $this->table_link;
    }
}

class dbCreateLink {
    function __construct( $link1, $link2, $tableName, $fieldArray ){
        $this->write_link($link1, $link2, $tableName, $fieldArray);
    }
    function write_link($l1, $l2, $table, $fArr){
        $values[]                               =$l1["id"];
        $values[]                               =$l2["id"];
        $writeLn                                = array_combine($fArr, $values);
        $searchStr                              = "";
        $arrCount                               = 0;
        foreach($fArr as $fa){
            $searchStr                          .= $fa."=".$values[$arrCount++]." and ";
        }
        $searchStr                              = substr($searchStr,0, strlen("$searchStr")-5);
        $checkLinkExists                        = dl::select($table, $searchStr);
        if(empty($checkLinkExists)) {
            dl::insert($table, $writeLn);
        }else{
            echo $table." - Record not written as both Patient and Sample records exist.";
        }
    }

}