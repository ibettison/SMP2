<?php

class sendSamples {

    public $samples;
    public $fileNames;
    public $connected;
    public $sFTPConnection;
    function __construct( $samplesToSend ) {
        $this->samples = $samplesToSend["sampleArray"];
        $this->fileNames = $this->prepareFileNames();
    }

    function prepareFileNames(){
        foreach($this->samples as $sample) {
            $sql = "select * from smp2_samples as s join smp2_patient_samples as ps on (s.s_id=ps.samples_id)
            join smp2_patients as p on (p.p_id=ps.patients_id) join smp2_filename as f on (s.s_id=f.samples_id)
            where sourceSampleIdentifier = '$sample'
            ";
            $sampleRec = dl::getQuery($sql);
            try{
                if(empty($sampleRec)) {
                    throw new Exception("<BR>ERROR - The filename was not found");
                }else{
                    $fileNames[] = array("fileName"=>$sampleRec[0]["filename"], "sampleID"=>$sampleRec[0]["s_id"], "sampleInfo"=>$sampleRec[0]["xml_sampleInfo"],
					"fullSampleInfo"=>$sampleRec[0]["xml_fullSampleInfo"]);
                }
            }catch( Exception $exception){
                die($exception->getMessage());
            }

        }
        return $fileNames;
    }

    function sendFileNames(){
        if($this->connected = sftpConnect::checkConnection()){
            $this->sFTPConnection = sftpConnect::getSFTPConnection();
            $this->processFiles($this->fileNames);
			$this->displayFiles();
        }else{
            die("sFTP connection Error!!! Not connected");
        }
    }

    function processFiles( $processFiles ) {
        foreach($processFiles as $files) {
            try {

				$checkStatus = dl::select("smp2_status", "samples_id = ".$files["sampleID"]);
				if(empty($checkStatus) or $checkStatus[0]["status"] == "Sent to TH"){
					$string2Send = $files["sampleInfo"];
					$this->connected->chdir($this->sFTPConnection->ftpSendFolder);
				}elseif($checkStatus[0]["status"] == "Ready to Archive"){
					$string2Send = $files["fullSampleInfo"];
					$this->connected->chdir($this->sFTPConnection->ftpArchiveFolder);
				}else{
					throw new Exception("<BR>The status of the file you are trying to send does not match the status allowed for transmission.");
				}
				$this->connected->put($files["fileName"],$string2Send);
				$this->updateStatus($files["sampleID"]);
            }catch( Exception $exception){
                die($exception->getMessage());
            }
        }
    }

    function displayFiles(){
        echo "<BR><h3>List of files in the folder</h3><BR>";
        $files = $this->connected->nlist();
        array_shift($files);
        array_shift($files);
        foreach($files as $file) {
            echo $file."<BR>";
        }
    }

    function updateStatus($sampleId) {
        $checkStatus = dl::select("smp2_status", "samples_id = ". $sampleId);
        if(empty($checkStatus)) {
            dl::insert("smp2_status", array("samples_id"=>$sampleId, "status"=>"Sent to TH"));
        }elseif($checkStatus[0]["status"] == "Ready to Archive"){
            dl::update("smp2_status", array("status"=>"Archived"), "samples_id = ".$sampleId);
        }
    }
}