<?php
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
try {
	if (file_exists(ROOT_FOLDER . "SMP2/library/includes/connection.json")) {
		include_once(ROOT_FOLDER . "SMP2/library/includes/mysqli_datalayer.php");
		$connect = json_decode(file_get_contents(ROOT_FOLDER . "SMP2/library/includes/connection.json"));
		if (!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
			throw new Exception("Cannot connect to the database");
		}else{
			$checkTables = dl::getQuery("select * from information_schema.tables where table_schema = 'smp2'");
			if(empty($checkTables)){
				createTables();

			}else{
				throw new Exception("Cannot create the NEW tables as they already exist.");
			}

		}
	} else {
		throw new Exception("Connection file does not exist. Please enter the connection information and select `Save Connection`.");
	}
} catch (Exception $e) {
	die($e->getMessage());
}


function createTables() {

	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_filename (
			fn_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  		samples_id mediumint(9) NOT NULL,
	  		filename varchar(50) NOT NULL,
	  		xml_sampleInfo mediumtext NOT NULL,
  			xml_fullSampleInfo mediumtext NOT NULL,
	  		PRIMARY KEY (fn_id)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_filename` created.";
	}else{
		echo "<BR>TABLE: `smp2_filename` exists not created.";
	}
	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_hub (
		h_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  hubName varchar(30) NOT NULL,
	  PRIMARY KEY (h_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_hub` created.";
	}else{
		echo "<BR>TABLE: `smp2_hub` exists not created.";
	}
	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_patients (
		p_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  h_id mediumint(9) NOT NULL,
	  organisationCode varchar(5) DEFAULT NULL,
	  localPatientIdentifier varchar(10) DEFAULT NULL,
	  treatingOncologistInitials varchar(3) DEFAULT NULL,
	  ageAtAttendance varchar(3) DEFAULT NULL,
	  genderCode varchar(1) DEFAULT NULL,
	  ethnicCategory varchar(2) DEFAULT NULL,
	  smokingStatus varchar(1) DEFAULT NULL,
	  noOfPriorLinesTherapy varchar(5) DEFAULT NULL,
	  cancerTreatmentModality varchar(50) DEFAULT NULL,
	  performanceStatus varchar(1) DEFAULT NULL,
	  PRIMARY KEY (p_id),
	  UNIQUE KEY localPatientIdentifier (localPatientIdentifier),
	  UNIQUE KEY localPatientIdentifier_2 (localPatientIdentifier)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_patients` created.";
	}else{
		echo "<BR>TABLE: `smp2_patients` exists not created.";
	}
	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_patient_samples (
		ps_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  patients_id mediumint(9) NOT NULL,
	  samples_id mediumint(9) NOT NULL,
	  PRIMARY KEY (ps_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_patient_samples` created.";
	}else{
		echo "<BR>TABLE: `smp2_patient_samples` exists not created.";
	}

	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_samples (
		s_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  sourceSampleIdentifier varchar(20) DEFAULT NULL,
	  originOfSample varchar(2) DEFAULT NULL,
	  typeOfSample varchar(2) DEFAULT NULL,
	  procedureToObtainSample varchar(1) DEFAULT NULL,
	  typeOfBiopsy varchar(1) DEFAULT NULL,
	  dateSampleTaken date DEFAULT NULL,
	  morphologySnomed varchar(18) DEFAULT NULL,
	  tumourType varchar(1) DEFAULT NULL,
	  pathologyTCategory varchar(3) DEFAULT NULL,
	  pathologyNCategory varchar(3) DEFAULT NULL,
	  pathologyMCategory varchar(3) DEFAULT NULL,
	  integratedTNMStageGrouping varchar(5) DEFAULT NULL,
	  alkStatus varchar(1) DEFAULT NULL,
	  egfrStatus varchar(1) DEFAULT NULL,
	  alkFishStatus varchar(1) DEFAULT NULL,
	  krasStatus varchar(1) DEFAULT NULL,
	  dateSampleSent date DEFAULT NULL,
	  PRIMARY KEY (s_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_samples` created.";
	}else{
		echo "<BR>TABLE: `smp2_samples` exists not created.";
	}

	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_sample_results (
		sr_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  sourceSampleIdentifier varchar(20) NOT NULL,
	  dateSampleReceived date NOT NULL,
	  labSampleIdentifier varchar(30) DEFAULT NULL,
	  reportReleaseDate date NOT NULL,
	  volumeBankedNucleicAcid varchar(10) DEFAULT NULL,
	  concentrationBankedNucleicAcid varchar(10) DEFAULT NULL,
	  bankedNucleicAcidLocation varchar(50) DEFAULT NULL,
	  bankedNucleicAcidIdentifier varchar(10) DEFAULT NULL,
	  PRIMARY KEY (sr_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_results` created.";
	}else{
		echo "<BR>TABLE: `smp2_results` exists not created.";
	}

	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_security (
		sec_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  sec_password varchar(100) NOT NULL,
	  PRIMARY KEY (sec_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_security` created.";
	}else{
		echo "<BR>TABLE: `smp2_security` exists not created.";
	}

	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_status (
		ss_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  samples_id mediumint(9) NOT NULL,
	  status varchar(20) NOT NULL,
	  datechanged timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (ss_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_status` created.";
	}else{
		echo "<BR>TABLE: `smp2_status` exists not created.";
	}


	$writeTable = "CREATE TABLE IF NOT EXISTS smp2_test_results (
		tr_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  sourceSampleIdentifier varchar(20) NOT NULL,
	  gene smallint(6) DEFAULT NULL,
	  methodOfTest smallint(6) DEFAULT NULL,
	  scopeOfTest varchar(100) DEFAULT NULL,
	  dateTestResultsReleased date NOT NULL,
	  testResult varchar(100) DEFAULT NULL,
	  testReport mediumtext,
	  testStatus smallint(6) DEFAULT NULL,
	  comments mediumtext,
	  PRIMARY KEY (tr_id)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
	$newTable = dl::_query($writeTable);
	if($newTable == 1) {
		echo "<BR>TABLE: `smp2_test_results` created.";
	}else{
		echo "<BR>TABLE: `smp2_test_results` exists not created.";
	}
}