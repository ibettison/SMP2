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
                    $fileNames[] = array("fileName"=>$sampleRec[0]["filename"], "sampleID"=>$sampleRec[0]["s_id"]);
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
            $this->connected->chdir($this->sFTPConnection->ftpSendFolder);
            $this->processFiles($this->fileNames);
            $this->displayFiles();
        }else{
            die("sFTP connection Error!!! Not connected");
        }
    }

    function processFiles( $processFiles ) {
        $local = NET_SFTP_LOCAL_FILE;
        foreach($processFiles as $files) {
            try {
                if(!file_exists(ROOT_FOLDER."/SMP2/xml-documents/".$files["fileName"])) {
                    throw new Exception("<BR>The file `".$files["fileName"]."` was not found in folder /SMP2/xml-documents/ - the file may already have been sent to the TH.");
                }
                $this->connected->put($files["fileName"],ROOT_FOLDER."/SMP2/xml-documents/".$files["fileName"], $local);
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

    function moveFiles() {
        //need to move the files to the files-sent folder
        foreach ($this->fileNames as $fn) {
            try{
                $this->move_file($fn["fileName"], $fn["sampleID"]);
            }catch( Exception $exception){
                die($exception->getMessage());
            }

        }
    }
    function move_file($fileName, $sampleId){
        if(!file_exists(ROOT_FOLDER."/SMP2/xml-documents/".$fileName)){
            throw new Exception( "File '$fileName' does not exist");
        }
        if(!rename(ROOT_FOLDER."/SMP2/xml-documents/".$fileName, ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$fileName )){
            throw new Exception("The file '$fileName' was not moved, there may be a permissions issue.");
        }
        if(!file_exists(ROOT_FOLDER."/SMP2/xml-documents/files-sent/".$fileName)){
            throw new Exception( "The file '$fileName' was not moved" );
        }
        $this->updateStatus($sampleId);
    }
    function updateStatus($sampleId) {
        $checkStatus = dl::select("smp2_status", "samples_id = ". $sampleId);
        if(empty($checkStatus)) {
            dl::insert("smp2_status", array("samples_id"=>$sampleId, "status"=>"Sent to TH"));
        }else{
            dl::update("smp2_status", array("status"=>"Sent to TH"), "samples_id = ".$sampleId);
        }
    }
}