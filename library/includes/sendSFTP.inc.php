<?php
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
set_include_path(get_include_path(). PATH_SEPARATOR . ROOT_FOLDER."/SMP2/library/Classes/phpseclib/phpseclib/");
require_once("Net/SFTP.php");
include(ROOT_FOLDER."/SMP2/library/Classes/sendSFTP.Class.php");