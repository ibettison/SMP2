<?php
class dbConnectionCheck {

    function create_connection( $postedValues ) {
		try{
			if(!file_put_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json", json_encode($postedValues))){
				throw new Exception("ERROR: there was a problem creating the connection file.");
			}else{
				if(file_exists(ROOT_FOLDER."/SMP2/library/includes/connection.json")) {
					echo "Connection file was created.";
				}
			}
		}catch(Exception $exception) {
			die($exception->getMessage());
		}
    }

    function check_connection( $posted_values ) {
		try{
			if(!$conn= dl::connect($posted_values["dbServer"],$posted_values["dbUserName"],$posted_values["dbPass"],$posted_values["dbName"])){
				throw new Exception("No connection to the database. Please check the connection information.");
			}else{
				echo "Connection to the database is active.";
			}
		}catch(Exception $exception){
			die($exception->getMessage());
		}
    }
}