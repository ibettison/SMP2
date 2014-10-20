<?php
if(session_id() == ''){
	session_start();
}
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect 		= json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn 		= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
//check status of the sample to edit.

$checkSample 	= dl::select("smp2_samples", "sourceSampleIdentifier = '".$_POST["sampleArray"][0]."'" );
$beenSent 		= dl::select("smp2_status", "samples_id =".$checkSample[0]["s_id"]);
$fileName 		= dl::select("smp2_filename", "samples_id =".$checkSample[0]["s_id"]);
//check the status so that the location can be checked if needed
if(!empty($beenSent)){
	if($beenSent[0]["status"] == "Sent to TH"){
		//now lets check whether the file has been moved on the remote server.
		include_once(ROOT_FOLDER."/SMP2/library/includes/sendSFTP.inc.php");
		if($connected = sftpConnect::checkConnection()){
			$sFTPConnection = sftpConnect::getSFTPConnection();
			$connected->chdir($sFTPConnection->ftpSendFolder);
			if(!$connected->get($fileName[0]["filename"])) {
				?>
				<script>
					alert("The remote file cannot be located, this may mean that the file has been moved to the received folder.\n\rPlease inform your Technical Hub with the details of the changes, identifying the new filename \n\ras the replacement.");
				</script>
				<?php
			}else{
				echo "<BR>File found on Remote server:";
			}
		}else{
			die("sFTP connection Error!!! Not connected");
		}
	}
}

$sql = "select * from smp2_samples as s
        join smp2_patient_samples as ps on (s.s_id=ps.samples_id)
        join smp2_patients as p on (ps.patients_id=p.p_id)
        join smp2_hub as h on (h.h_id=p.h_id)
        left outer join smp2_status as st on (st.samples_id=s.s_id)
        where sourceSampleIdentifier = '".$_POST["sampleArray"][0]."'";
$viewRecord = dl::getQuery($sql);

try{
    if(empty($viewRecord)) {
        throw new Exception("Cannot find the information you requested");
    }else{
        $treatments = array("01 - Surgery","02 - Anti-cancer drug regimen (Cytotoxic Chemotherapy)","03 - Anti-cancer drug regimen (Hormone therapy)",
            "04 - Chemoradiotherapy",
            "05 - Teletherapy (Beam Radiation excluding Proton Therapy)",
            "06 - Brachytherapy",
            "07 - Specialist Palliative Care",
            "08 - Active Monitoring (excluding non-specialist Palliative Care)",
            "09 - Non-specialist Palliative Care (excluding Active Monitoring)",
            "10 - Radio Frequency Ablation (RFA)",
            "11 - High Intensity Focussed Ultrasound (HIFU)",
            "12 - Cryotherapy",
            "13 - Proton Therapy",
            "14 - Anti-cancer drug regimen (other)",
            "15 - Anti-cancer drug regimen (Immunotherapy)",
            "16 - Light Therapy (including Photodynamic Therapy and Psoralen and Ultra Violet A (PUVA) Therapy)",
            "17 - Hyperbaric Oxygen Therapy",
            "19 - Radioisotope Therapy (including Radioiodine)",
            "20 - Laser Treatment (including Argon Beam therapy)",
            "21 - Biological Therapies (excluding Immunotherapy)",
            "22 - Radiosurgery",
            "97 - Other Treatment",
            "98 - All treatment declined");
        if(!empty($viewRecord[0]["cancerTreatmentModality"])){
            $inString = explode(",", $viewRecord[0]["cancerTreatmentModality"]);
            $multiVals="";
            foreach($inString as $in){
                foreach($treatments as $treatment) {
                    $POS = strpos($treatment,$in);
                    if($POS === 0){
                        $multiVals .= '"'.$treatment.'",';
                    }
                }
            }
            $multiVals = substr($multiVals,0, strlen($multiVals)-1);
	        ?>
	        <script>
		    var modality = [<?php echo $multiVals;?>];
		    $("#cancerTreatmentModality")   .val(modality);
	        </script>
        <?php
        }else{?>
	        <script>
	        var modality = [];
		    $("#cancerTreatmentModality")   .val(modality);
	        </script>
	    <?php
        }
	    ?>
	    <script>
        $("#hubName")                       .val("<?php echo $viewRecord[0]["hubName"]?>");
        $("#organisationCode")              .val("<?php echo $viewRecord[0]["organisationCode"]?>");
        $("#localPatientIdentifier")        .val("<?php echo $viewRecord[0]["localPatientIdentifier"]?>");
        $("#treatingOncologistInitials")    .val("<?php echo $viewRecord[0]["treatingOncologistInitials"]?>");
        $("#ageAtAttendance")               .val("<?php echo $viewRecord[0]["ageAtAttendance"]?>");
        $("#genderCode")                    .val("<?php echo $viewRecord[0]["genderCode"] == null 				? "#" : $viewRecord[0]["genderCode"] ?>");
        $("#ethnicCategory")                .val("<?php echo empty($viewRecord[0]["ethnicCategory"]) 			? "#" : $viewRecord[0]["ethnicCategory"] ?>");
        $("#smokingStatus")                 .val("<?php echo empty($viewRecord[0]["smokingStatus"]) 			? "#" : $viewRecord[0]["smokingStatus"] ?>");
        $("#noOfPriorLinesTherapy")         .val("<?php echo $viewRecord[0]["noOfPriorLinesTherapy"]?>");
        $("#performanceStatus")             .val("<?php echo $viewRecord[0]["performanceStatus"] == null 		? "#" : $viewRecord[0]["performanceStatus"] ?>");
        $("#sourceSampleIdentifier")        .val("<?php echo $viewRecord[0]["sourceSampleIdentifier"]?>");
        $("#originOfSample")                .val("<?php echo empty($viewRecord[0]["originOfSample"]) 			? "#" : $viewRecord[0]["originOfSample"] ?>");
        $("#typeOfSample")                  .val("<?php echo empty($viewRecord[0]["typeOfSample"]) 				? "#" : $viewRecord[0]["typeOfSample"] ?>");
        $("#procedureToObtainSample")       .val("<?php echo empty($viewRecord[0]["procedureToObtainSample"]) 	? "#" : $viewRecord[0]["procedureToObtainSample"] ?>");
        $("#typeOfBiopsy")                  .val("<?php echo $viewRecord[0]["typeOfBiopsy"] == null				? "#" : $viewRecord[0]["typeOfBiopsy"] ?>");
        $("#dateSampleTaken")               .val("<?php echo $viewRecord[0]["dateSampleTaken"]?>");
        $("#tumourType")                    .val("<?php echo empty($viewRecord[0]["tumourType"])				? "#" : $viewRecord[0]["tumourType"] ?>");
        $("#morphologySnomed")              .val("<?php echo $viewRecord[0]["morphologySnomed"]?>");
        $("#pathologyTCategory")            .val("<?php echo $viewRecord[0]["pathologyTCategory"] == null		? "#" : $viewRecord[0]["pathologyTCategory"] ?>");
        $("#pathologyNCategory")            .val("<?php echo $viewRecord[0]["pathologyNCategory"] == null		? "#" : $viewRecord[0]["pathologyNCategory"] ?>");
        $("#pathologyMCategory")            .val("<?php echo $viewRecord[0]["pathologyMCategory"] == null		? "#" : $viewRecord[0]["pathologyMCategory"] ?>");
        $("#integratedTNMStageGrouping")    .val("<?php echo $viewRecord[0]["integratedTNMStageGrouping"]?>");
        $("#alkStatus")                     .val("<?php echo empty($viewRecord[0]["alkStatus"])					? "#" : $viewRecord[0]["alkStatus"] ?>");
        $("#egfrStatus")                    .val("<?php echo empty($viewRecord[0]["egfrStatus"])				? "#" : $viewRecord[0]["egfrStatus"] ?>");
        $("#alkFishStatus")                 .val("<?php echo empty($viewRecord[0]["alkFishStatus"])				? "#" : $viewRecord[0]["alkFishStatus"] ?>");
        $("#krasStatus")                    .val("<?php echo empty($viewRecord[0]["krasStatus"])				? "#" : $viewRecord[0]["krasStatus"] ?>");
        $("#dateSampleSent")                .val("<?php echo $viewRecord[0]["dateSampleSent"]?>");
        </script>
        <?php
		$_SESSION["fieldValues"] 			= array(	"hubName"=>$viewRecord[0]["hubName"],
											"localPatientIdentifier"=>$viewRecord[0]["localPatientIdentifier"],
											"organisationCode"=>$viewRecord[0]["organisationCode"],
											"sourceSampleIdentifier"=>$viewRecord[0]["sourceSampleIdentifier"]);
		$_SESSION["sampleStatus"]			= $viewRecord[0]["status"];
    }
}catch (Exception $exception) {
    dl::closedb();
    die($exception->getMessage());
}
dl::closedb();