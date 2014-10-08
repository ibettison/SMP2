<?php
class sampleStatus {
	private $sample;
	private $sampleRS;

	function __construct($sampleID){
		$this->sample = $sampleID;
		$this->sampleRS = dl::select("smp2_status", "samples_id = '".$this->sample."'");
	}

	function get_status(){
		try{
			if(!empty($this->sampleRS)){
				return $this->sampleRS["status"];
			}else{
				return "Not sent";
			}

		}catch( Exception $exception){
			die($exception->getMessage());
		}

	}
}