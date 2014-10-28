<?php
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
require(ROOT_FOLDER."/SMP2/vendor/autoload.php");
include(ROOT_FOLDER."/SMP2/library/Classes/sendSFTP.Class.php");