<?php
class checkResults {
	public $connect;
	public $fileNames;
	public $fileLocation;
	public $sampleID;

	public $sampleDetails;
	Public $testDetails;

	function findResults($resultsFolder) {
		try{
			if(!$this->connect = sftpConnect::checkConnection()) {
				throw new Exception("The connection to the sFTP server is unavailable.");
			}
			$this->connect->chdir($resultsFolder);
			$folderList = $this->connect->nlist();
			//now need to remove the first two elements in the array as these are the . and the .. folders
			array_shift($folderList);
			array_shift($folderList);
			if(!empty($folderList)) {
				//there are results waiting attention
				return $this->fileNames = $folderList;
			}else{
				throw new Exception("There were no results found.");
			}
		}catch(Exception $exception){
			die($exception->getMessage());
		}
	}

	function findRecords($resultsList){
		foreach($resultsList as $files) {
			if($result = simplexml_load_file($this->connect->get($files))){
				try{
					$sampleIdentifier = $result->xpath("//sourceSampleIdentifier/text()");
					if(empty($sampleIdentifier)){
						throw new Exception("No sample identifier found.");
					}

					foreach($sampleIdentifier as $sampleValue) {
						$this->sampleID = (string)$sampleValue;
					}
					//check the sample exists in the sample table
					$exists = dl::select("smp2_samples", "sourceSampleIdentifier = '".$this->sampleID."'");
					if(empty($exists)){
						throw new Exception("The sample cannot be found no record written.");
					}else{
						//lets check if the results have already been gathered
						$resultRec = dl::select("smp2_sample_results", "sourceSampleIdentifier = '".$this->sampleID."'");
						if(empty($resultRec)){
							$technologyHub 					= $result->sample->technologyHubElements;
							$this->sampleDetails			= array(
								"sourceSampleIdentifier"		=>$this->sampleID,
								"dateSampleReceived"			=>(string)$technologyHub->dateSampleReceived,
								"labSampleIdentifier"			=>(string)$technologyHub->labSampleIdentifier,
								"reportReleaseDate"				=>(string)$technologyHub->reportReleaseDate,
								"volumeBankedNucleicAcid"		=>(string)$technologyHub->volumeBankedNucleicAcid,
								"concentrationBankedNucleicAcid"=>(string)$technologyHub->concentrationBankedNucleicAcid,
								"bankedNucleicAcidLocation"		=>(string)$technologyHub->bankedNucleicAcidLocation,
								"bankedNucleicAcidIdentifier"	=>(string)$technologyHub->bankedNucleicAcidIdentifier);
							$tests = (array)$result->xpath("//test");
							if(empty($tests)) {
								throw new Exception("No test results were found. No record written.");
							}
							foreach($tests as $test){
								$object 					= $test;
								$methArr="";
								foreach($object->methodsOfTest->children() as $method){
									$methArr[]=(string)$method;
								}
								$this->testDetails[] 		= array(
									"sourceSampleIdentifier"	=>$this->sampleID,
									"gene"						=>(string)$object->gene,
									"methodOfTest"				=>implode(",", $methArr),
									"scopeOfTest"				=>(string)$object->scopeOfTest,
									"dateTestResultsReleased"	=>(string)$object->dateTestResultsReleased,
									"testResult"				=>(string)$object->testResult,
									"testReport"				=>(string)$object->testReport,
									"testStatus"				=>(string)$object->testStatus,
									"comments"					=>(string)$object->comments
								);
							}
						}
					}

				}catch(Exception $exception){
					die($exception->getMessage());
				}
			}else{
				echo "<BR> xml file ".$files." was not loaded.";
			}
		}
	}

	function writeRecords(){
		$exists = dl::select("smp2_sample_results", "sourceSampleIdentifier = '".$this->sampleID."'");
		if(!$exists){
			dl::insert("smp2_sample_results",$this->sampleDetails);
			foreach($this->testDetails as $td){
				dl::insert("smp2_test_results", $td);
			}
			//last thing to do is update the status for the sample results.
			$status = dl::select("smp2_samples", "sourceSampleIdentifier = '".$this->sampleID."'");
			dl::update("smp2_status", array("status"=>"Results Received"), "samples_id = ".$status[0]["s_id"]);
			return true;
		}else{
			return false;
		}
	}
}