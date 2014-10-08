<?php
class dbUpdate extends dbWrite {
	private $tableValues;
	private $fieldName;
	function __construct( $fields, $table, $link, $existingRecordCheck, $updateTables ){
		$this->tableValues = $updateTables;
		$this->fieldName = $existingRecordCheck;
		parent::__construct($fields, $table, $link, $existingRecordCheck);
	}

    function doesRecordExist($checkRecordExists, $table, $writeLn, $index) {
		echo $table." - record has been updated.<BR>";
		$lastId  = $checkRecordExists[0][$index];
		$this->set_index($table, $index, $lastId);
		dl::update($table, $writeLn, $this->fieldName."='".$this->tableValues["FieldValue"]."'" );
		//now need to change the status of the sample to `Edited`
		if($this->table_link["tableName"] == "smp2_samples"){
			dl::update("smp2_status", array("status"=>"Edited"), "samples_id = ".$this->table_link["id"]);
		}
		$this->set_dataWritten(true);
    }
}