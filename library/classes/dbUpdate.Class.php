<?php
class dbUpdate extends dbWrite {
	private $tableValues;
	private $fieldName;
	public $statusChange;

	function __construct( $fields, $table, $link, $existingRecordCheck, $updateTables ){
		$this->tableValues 								= $updateTables;
		$this->fieldName 								= $existingRecordCheck;
		parent::__construct($fields, $table, $link, $existingRecordCheck);
	}

    function doesRecordExist($checkRecordExists, $table, $writeLn, $index) {
		$lastId  										= $checkRecordExists[0][$index];
		$this->set_index($table, $index, $lastId);
		$checkStatus 									= dl::select("smp2_status", "samples_id = ".$this->table_link["id"]);
		try{
			if($this->table_link["tableName"] 			== "smp2_samples"){
				if(!empty($checkStatus)){
					if($checkStatus[0]["status"] 		== "Results Received"){
						$this->statusChange 			= true;
						//now need to change the status of the sample to `Ready to Archive`
						dl::update("smp2_status", array("status"=>"Ready to Archive"), "samples_id = ".$this->table_link["id"]);
					}elseif($checkStatus[0]["status"] 	== "Ready to Archive" or $checkStatus[0]["status"] 	== "Archived" ){
						throw new Exception("The status of this record `".$checkStatus[0]["status"]."`, prevents any further editing of this record. No update has occurred.");
					}
				}
			}
			dl::update($table, $writeLn, $this->fieldName."='".$this->tableValues["FieldValue"]."'" );
			echo $table." - record has been updated.<BR>";
		}catch(Exception $exception){
			die($exception->getMessage());
		}
		$this->set_dataWritten(true);
    }
}