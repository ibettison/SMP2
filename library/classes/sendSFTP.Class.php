<?php
class sftpConnect{
    static private $sFTPConnection;
	static public $ftpServer;
	static public $ftpUserName;
	static public $ftpPassword;
	static public $ftpSendFolder;
	static public $ftpResultFolder;
	static public $ftpArchiveFolder;
	static public $connectFtp;

    static public function createSFTPConnection($user, $pass, $send, $result, $archive){
		$jsonArray = array("ftpUserName"=>$user, "ftpPassword"=>$pass, "ftpSendFolder"=>$send, "ftpResultFolder"=>$result, "ftpArchiveFolder"=>$archive);
		try{
			if(!file_put_contents(ROOT_FOLDER."SMP2/library/includes/ftpConnect.json", json_encode($jsonArray))){
				throw new Exception("The .json file was not created, there may be a permissions issue.");
			}else{
				echo "The .json file was created.";
			}
		}catch(Exception $exception){
			die($exception->getMessage());
		}
    }

    static public function getSFTPConnection(){
        return json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/ftpConnect.json"));
    }

	/**
	 * @function getSFTPServer This is the hardcoded link to the SFTP server
	 * @return string server address for the SFTP server
	 */
	static public function getSFTPServer(){
		return "143.65.192.45";
	}

    static public function checkConnection() {
        self::$sFTPConnection 			= self::getSFTPConnection();
		self::$ftpServer				= self::getSFTPServer();
        $conn 							= new Net_SFTP(self::$ftpServer);
        if(!$conn->login(self::$sFTPConnection->ftpUserName, self::$sFTPConnection->ftpPassword)){
            return false;
        }else{
            echo "Logged in to SFTP Server.";
            return $conn;
        }
    }

	static public function connectionVariables(){
		if(file_exists(ROOT_FOLDER."SMP2/library/includes/ftpConnect.json")) {
			self::$connectFtp 			= json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/ftpConnect.json"));
			self::$ftpServer 			= self::getSFTPServer();
			self::$ftpUserName 			= self::$connectFtp->ftpUserName;
			self::$ftpPassword 			= self::$connectFtp->ftpPassword;
			self::$ftpSendFolder 		= self::$connectFtp->ftpSendFolder;
			self::$ftpResultFolder 		= self::$connectFtp->ftpResultFolder;
			self::$ftpArchiveFolder 	= self::$connectFtp->ftpArchiveFolder;
			$connection = array("server"=>self::$ftpServer, "user"=>self::$ftpUserName, "password"=>self::$ftpPassword,
			"sendFolder"=>self::$ftpSendFolder, "resultFolder"=>self::$ftpResultFolder, "archiveFolder"=>self::$ftpArchiveFolder);
			return $connection;
		}else{
			self::$ftpServer 			= "";
			self::$ftpUserName 			= "";
			self::$ftpPassword 			= "";
			self::$ftpSendFolder 		= "";
			self::$ftpResultFolder 		= "";
			self::$ftpArchiveFolder 	= "";
			return false;
		}
	}
}

