<?php
class sftpConnect{
    static private $sFTPConnection;

    static public function createSFTPConnection($server, $user, $pass, $send, $result){
        $jsonArray = array("ftpServer"=>$server, "ftpUserName"=>$user, "ftpPassword"=>$pass, "ftpSendFolder"=>$send, "ftpResultFolder"=>$result);
        file_put_contents("../../ftpConnect.json", json_encode($jsonArray));
    }

    static private function getSFTPConnection(){
        return json_decode(file_get_contents("ftpConnect.json"));
    }

    static public function checkConnection() {
        error_reporting(E_ALL & ~E_WARNING);
        self::$sFTPConnection = self::getSFTPConnection();
        $conn = new Net_SFTP(self::$sFTPConnection->ftpServer);
        if(!$conn->login(self::$sFTPConnection->ftpUserName, self::$sFTPConnection->ftpPassword)){
            echo "Connection Failed";
        }else{
            echo "Logged in";
            /*echo $conn->pwd();
            echo $conn->chdir("CDF_NCSL_Sent");
            echo $conn->pwd();
            print_r( $conn->nlist());
            $local = NET_SFTP_LOCAL_FILE;
            $conn->put("test_2014-09-08_NEW05_46470_841991HUB5.xml","xml-documents/test_2014-09-08_NEW05_46470_841991HUB5.xml", $local);
            print_r( $conn->nlist());*/
        }
    }
}

