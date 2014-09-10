<?php
if($_GET["func"]== "create") {
    $connection = new dbConnectionCheck();
    $connection->create_connection($_POST);
}elseif($_GET["func"] == "check") {
    require_once                 ("../mysqli_datalayer.php");
    $connection = new dbConnectionCheck();
    $connection->check_connection($_POST);
}

class dbConnectionCheck {

    function create_connection( $postedValues ) {
        file_put_contents("../../connection.json", json_encode($postedValues));
        if(file_exists("../../connection.json")) {
            echo "Connection file was created.";
        }else{
            echo "ERROR: there was a problem creating the connection file.";
        }
    }

    function check_connection( $posted_values ) {
        $conn= dl::connect($posted_values["dbServer"],$posted_values["dbUserName"],$posted_values["dbPass"],$posted_values["dbName"]);

        if($conn) {
            echo "Connection to the database is active.";
        }else{
            echo "Cannot make a connection.";
        }
    }
}