<?php
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
$root = $_SERVER["DOCUMENT_ROOT"];
define('ROOT_FOLDER', $root);
}
require_once(ROOT_FOLDER."/SMP2/library/includes/sendSFTP.inc.php");
require_once(ROOT_FOLDER."/SMP2/library/Classes/sendSamples.Class.php");
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect = json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
die("Cannot connect to the database");
}
$send = new sendSamples( $_POST );
$send->sendFileNames();
$send->moveFiles();
dl::closedb();