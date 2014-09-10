<?php
require_once("sendSFTP.Class.php");
sftpConnect::createSFTPConnection($_POST["ftpServer"], $_POST["ftpUserName"], $_POST["ftpPassword"], $_POST["ftpSendFolder"], $_POST["ftpResultFolder"]);