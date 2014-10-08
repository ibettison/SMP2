<?php
class sftpConnect{
    static private $sFTPConnection;

    static public function createSFTPConnection($server, $user, $pass, $send, $result, $archive){
		$jsonArray = array("ftpServer"=>$server, "ftpUserName"=>$user, "ftpPassword"=>$pass, "ftpSendFolder"=>$send, "ftpResultFolder"=>$result, "ftpArchiveFolder"=>$archive);
		try{
			if(!file_put_contents(ROOT_FOLDER."/SMP2/library/includes/ftpConnect.json", json_encode($jsonArray))){
				throw new Exception("The .json file was not created, there may be a permissions issue.");
			}else{
				echo "The .json file was created.";
			}
		}catch(Exception $exception){
			die($exception->getMessage());
		}
    }

    static public function getSFTPConnection(){
        return json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/ftpConnect.json"));
    }

    static public function checkConnection() {

        error_reporting(E_ALL & ~E_WARNING);
        self::$sFTPConnection = self::getSFTPConnection();
        $conn = new Net_SFTP(self::$sFTPConnection->ftpServer);
        if(!$conn->login(self::$sFTPConnection->ftpUserName, self::$sFTPConnection->ftpPassword)){
            return false;
        }else{
            echo "Logged in to SFTP Server.";
            return $conn;
        }
    }
}

