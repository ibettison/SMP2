<?php

if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}

if(file_exists(ROOT_FOLDER."SMP2/library/includes/connection.json")) {
	$connectionString = json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
	$connDB = $connectionString->dbName;
	$connUser = $connectionString->dbUserName;
	$connPass = $connectionString->dbPass;
	$connServer = $connectionString->dbServer;
}else{
	$connDB = "";
	$connUser = "";
	$connPass = "";
	$connServer = "";
}
echo "<div id='newConnectionForm' style='display: none; padding-top: 4em;'>";
//setup the form for submission and validation
echo "<form id='smp2_connection' action='index.php' method='get'>";
//start entering the fields to create the XML report
echo "<div class='row'>";
echo "<h3>Connection Information</h3>";
echo "<p>Once a connection to the database is achieved you will not need to change this again.</p>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field'>
                <input class='input' type='text' placeholder='Enter database name' id='dbName' name='dbName' value='$connDB'/>
                  </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field'>
                    <input class='input' type='text' placeholder='Enter the User Name' id='dbUserName' name='dbUserName' value='$connUser'/>
                  </div>";
echo "</div>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field'>
                        <input class='input' type='password' placeholder='Enter password' id='dbPass' name='dbPass' value='$connPass'/>
                          </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field'>
                            <input class='input' type='text' placeholder='Enter the Server Name (should be IP Address or localhost)' id='dbServer' name='dbServer' value='$connServer'/>
                          </div>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
echo "<div  class='medium rounded metro primary btn'><input id='submit_connection' type='submit' value='Save Connection' /></div> ";
echo " <div  class='medium rounded metro primary btn'><input id='check_connection' type='button' value='Check Connection' /></div>";
echo " <div  class='medium rounded metro primary btn'><input id='check_close' type='button' value='Close' /></div>";
echo "<p>Type in the connection information above then press the `Check Connection` button to check the connectivity.</p>";
echo "</div>";
echo "</form>";
echo "</div>"; //end div for newConnection Form
echo "<div class='row'>";
echo"<div id='connMessage'></div>";
echo "</div>";
?>
<script>
	$('#smp2_connection').validation({
		// pass an array of required field objects
		required: [
			{
				// name should reference a form inputs name attribute
				// just passing the name property will default to a check for a present value
				name: 'dbName',
				validate: function($e) {
					return $e.val().length >0;
				}
			},
			{
				name: 'dbUserName',
				validate: function($e) {
					return $e.val().length >0;
				}
			},
			{
				name: 'dbPass',
				validate: function($e) {
					return $e.val().length >0;
				}
			},
			{
				name: 'dbServer',
				validate: function($e) {
					return $e.val().length >0;
				}
			},
		],
		// callback for failed validation on form submit
		fail: function() {
			alert("Form validation failed");
			Gumby.error('Form validation failed');
		},
// callback for successful validation on form submit
// if omitted, form will submit normally
		submit: function(data) {
			$.ajax({
				url: 'library/includes/dbConnCheck.inc.php?func=create',
				data: data,
				type: "POST",
				success: function(data) {
					$("#connMessage").show();
					$("#connMessage").html(data);
					$("#connMessage").delay(1200).fadeOut(900);
				}
			});
		}
	});
	$("#check_connection").click(function(){
		var dbName = $("#dbName").val();
		var dbUserName = $("#dbUserName").val();
		var dbPass = $("#dbPass").val();
		var dbServer = $("#dbServer").val();
		$.ajax({
			url: 'library/includes/dbConnCheck.inc.php?func=check',
			data: {dbName: dbName,
				dbUserName: dbUserName,
				dbPass: dbPass,
				dbServer: dbServer
			},
			type: "POST",
			success: function(data) {
				$("#connMessage").show();
				$("#connMessage").html(data);
				$("#connMessage").delay(1200).fadeOut(900);
			}
		});
	});
	$("#check_close").click(function(){
		$("#connMessage").html("");
		$("#newConnectionForm").delay(200).slideUp(900);
	});
</script>