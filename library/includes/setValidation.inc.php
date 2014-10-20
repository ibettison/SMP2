<?php
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}

include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect 			= json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn 			= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}

if($_POST["sampleStatus"]!== "New"){
	$url 			= "'library/includes/dbUpdate.inc.php'";
}else{
	$url 			= "'library/includes/dbWrite.inc.php'";
}
if($_POST["sampleStatus"] == "New" or $_POST["sampleStatus"] == "Sent to TH" or $_POST["sampleStatus"] == "Not Sent"){
	require_once(ROOT_FOLDER."/SMP2/library/includes/validation.inc.php");
}elseif($_POST["sampleStatus"] == "Results Received" or $_POST["sampleStatus"] == "Ready to Archive"){
	require_once(ROOT_FOLDER."/SMP2/library/includes/fullvalidation.inc.php");
	?>
	<script>
		$("#viewResults").show();
	</script>
<?php
}
dl::closedb();