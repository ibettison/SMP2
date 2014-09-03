<?php
/**
 * Created by PhpStorm.
 * User: nib8
 * Date: 02/09/14
 * Time: 15:03
 */

//link to database access and connection
include              ("../mysqli_datalayer.php");
include              ("../connection.php");

//list of file details for table smp2_hub
$hubFieldNames       = array("h_id", "hubName");
$hubTable            = "smp2_hub";
$hubLink             = Null;
$hubCheck            = "hubName";
$writeTables         = new dbWrite($hubFieldNames, $hubTable, $hubLink, $hubCheck);

//list of file details for table smp2_patients
$hubTableLink = $writeTables->get_index(); //this gets the index info from the Hub table
$patientFieldNames   = array("p_id","h_id","organisationCode","localPatientIdentifier","treatingOncologistInitials",
    "ageAtAttendance","genderCode","ethnicCategory","smokingStatus","noOfPriorLinesTherapy","cancerTreatmentModality",
    "performanceStatus");
$patientTable        = "smp2_patients";
$patientLink         = array("tableName"=>"smp2_hub");
$patientCheck        = "localPatientIdentifier";
$writeTables = new dbWrite($patientFieldNames, $patientTable, $patientLink, $patientCheck);
$patientTableLink = $writeTables->get_index(); //this gets the index info from the Patients table


class dbWrite {
    public $table_link;
    function __construct( $fields, $table, $link, $existingRecordCheck ){
        $this->write_data($fields, $table, $link, $existingRecordCheck);

    }

    function write_data ( $fieldArray, $table, $link, $check ) {
        //set as debug
        dl::$debug = true;
        //take the first element off of the array as this is the index.
        $index                                  = array_shift($fieldArray);
        foreach($fieldArray as $field) {
            //the field may not be in the POST array as it is an optional field so lets check for the key

            if(array_key_exists($field, $_POST)){

                //check if the key is an array
                if(is_array($_POST[$field])){
                    $listOfTreatmentTypes       = "";
                   foreach($_POST[$field] as $val) {
                       //create comma delimited
                        $listOfTreatmentTypes  .= substr($val,0,2).",";
                    }
                    $listOfTreatmentTypes       = substr($listOfTreatmentTypes,0,strlen($listOfTreatmentTypes)-1);
                    $values[]                   = $listOfTreatmentTypes;
                }else{
                    $values[]                   = $_POST[$field];
                }

            }else{
                $values[]                       = "";
            }

        }
        $writeLn                                = array_combine($fieldArray, $values);
        //print_r($writeLn);
        $checkRecordExists = dl::select($table,$check."=".$_POST[$check]);
        if(empty($checkRecordExists)){
            //dl::insert($table, $writeLn);
            $lastId = dl::getId();
            $this->set_index($table, $index, $lastId);
        }else{
            echo $table." - record was not updated as the data already exists.";
            $lastId = $checkRecordExists[0][$index];
            $this->set_index($table, $index, $lastId);
        }

    }
//TODO: need to add the link connection to the required tables - Patient needs to connect to Hub etc.
//TODO: also need to create a class function to create a link table for a m:n relationship

    function set_index ($table, $index, $id) {
        $this->table_link                     = array("tableName"=>$table, "indexField"=>$index, "id"=>$id);
        var_dump($this->table_link);
    }

    function get_index() {
        return $this->table_link;
    }
}