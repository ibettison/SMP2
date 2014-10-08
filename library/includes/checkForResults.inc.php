<?php
if(!defined("ROOT_FOLDER")){
$root = $_SERVER["DOCUMENT_ROOT"];
define('ROOT_FOLDER', $root);
}
require_once(ROOT_FOLDER."/SMP2/library/includes/sendSFTP.inc.php");
require_once(ROOT_FOLDER."/SMP2/library/Classes/sendSamples.Class.php");
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");