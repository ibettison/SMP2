<?php
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
define('SALT', '&*76667(-==-(06uhgsk23');
include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
$connect 						= json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
if(!$conn 						= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
$security = dl::select("smp2_security");
if(empty($security)){
	$hashed_password 			= crypt($_POST["pwPassword"], "$2a$11$".bin2hex(SALT));
	dl::insert("smp2_security", array("sec_password"=>$hashed_password));
}else{
	$hashed_old_password 		= crypt($_POST["pwOldPassword"], "$2a$11$".bin2hex(SALT));
	$hashed_password 			= crypt($_POST["pwPassword"], "$2a$11$".bin2hex(SALT));

	if($hashed_old_password 	== $security[0]["sec_password"]){
		// the old password has been matched now change the password to the new one
		dl::update("smp2_security", array("sec_password"=>$hashed_password), "sec_id = ". $security[0]["sec_id"]);
		echo "Password changed";
	}else{
		echo "Old password mismatch. No change occurred.";
	}
}



