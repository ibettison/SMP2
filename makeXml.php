<?php

//link to database access and connection
include("library/mysqli_datalayer.php");
include("library/connection.php");
include("library/classes/makeXMLFile.Class.php");
dl::$debug = true;
$id = $_GET["id"];
makeXML::makeXMLFile($id);

