<?php
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
require_once("sendSFTP.Class.php");
sftpConnect::createSFTPConnection($_POST["ftpServer"], $_POST["ftpUserName"], $_POST["ftpPassword"], $_POST["ftpSendFolder"], $_POST["ftpResultFolder"],$_POST["ftpArchiveFolder"]);