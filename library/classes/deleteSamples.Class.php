<?php

class deleteSamples extends sendSamples{

    function sendFileNames(){
        if($this->connected = sftpConnect::checkConnection()){
            $sFTPConnection = sftpConnect::getSFTPConnection();
            $this->connected->chdir($sFTPConnection->ftpSendFolder);
            $this->processFiles($this->fileNames);
            //$this->displayFiles();
        }else{
            die("sFTP connection Error!!! Not connected");
        }
    }

    function processFiles( $processFiles ) {
        $local = NET_SFTP_LOCAL_FILE;
        foreach($processFiles as $files) {
            try {
				//check the status of this sample to see if it can be deleted
				$canBeDeleted = dl::select("smp2_status", "samples_id = ".$files["sampleID"]);
				if(!empty($canBeDeleted)){
					if($canBeDeleted[0]["status"] == "Results Received" or $canBeDeleted[0]["status"] == "Ready to Archive"
						or $canBeDeleted[0]["status"] == "Archived"){
						throw new Exception("The status of this record prevents its deletion. Record deletion is not possible!");
					}
				}
                //lets check to see if the file has not been sent yet.
                if(file_exists(ROOT_FOLDER."/SMP2/xml-documents/".$files["fileName"])){
                    if(unlink(ROOT_FOLDER."/SMP2/xml-documents/".$files["fileName"])) { //delete the unsent file
                        $this->updateStatus($files["sampleID"]);
                        echo "<BR>Deleted File `".$files["fileName"]."` from local server.";
                    }
                }else{
					if(!file_exists(ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$files["fileName"])) {
						throw new Exception("<BR>The file `".$files["fileName"]."` was not found in folder /SMP2/xml-documents/files-sent - the file may already have been deleted.");
					}else{
						if(!$this->connected->get($files["fileName"])){
							//the file on the remote server is not in the folder so assume it has been moved to Received folder so inform the user and make no change to database
							throw new Exception("<BR>The file `".$files["fileName"]."` was not found in the remote sent folder, <BR>assume it has been moved to the received folder. No deletion occurred!");
						}else{
							$this->connected->delete($files["fileName"],ROOT_FOLDER."/SMP2/xml-documents/files-sent".$files["fileName"], $local);
							if(unlink(ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$files["fileName"])) { //delete the sent file
								$this->updateStatus($files["sampleID"]);
								echo "<BR>Deleted File `".$files["fileName"]."` from local and remote servers.";
							}
						}
					}
				}

            }catch( Exception $exception){
                die($exception->getMessage());
            }
        }
    }

    function move_file($fileName, $sampleId){
        if(!file_exists(ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$fileName)){
            throw new Exception( "File '$fileName' not found.");
        }
        if(!unlink( ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$fileName )){
            throw new Exception("The file '$fileName' was not deleted, there may be a permissions issue.");
        }
        $this->updateStatus($sampleId);
    }

    function updateStatus($sampleId) {
        try {
            $checkPatient = dl::select("smp2_patient_samples", "samples_id = ". $sampleId);
            if(!empty($checkPatient)) {
                $patientID = $checkPatient[0]["patients_id"];
                $patientRecs = dl::select("smp2_patient_samples", "patients_id = ". $patientID);
                //need to check if there are more than this sample attached to the Patient record
                if(dl::getNumRows() === 1) {
                   //can delete patient record
                   dl::delete("smp2_patients", "p_id = ". $patientID); //delete the patients record
                }
                dl::delete("smp2_samples", "s_id = ". $sampleId); //delete the samples record
                dl::delete("smp2_patient_samples", "samples_id = ".$sampleId); // delete the linking record
                dl::delete("smp2_status", "samples_id = ".$sampleId); // delete the status record
                dl::delete("smp2_filename", "samples_id = ".$sampleId);
            }else{
                throw new Exception("There is no smp2_patients_samples record.");
            }
        }catch( Exception $exception){
            die($exception->getMessage());
        }

    }
}