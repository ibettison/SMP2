<?php
if(!defined("ROOT_FOLDER")){
$root = $_SERVER["DOCUMENT_ROOT"];
define('ROOT_FOLDER', $root);
}
if(file_exists(ROOT_FOLDER."/SMP2/library/includes/ftpConnect.json")) {
    $connectFtp = json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/ftpConnect.json"));
    $ftpServer = $connectFtp->ftpServer;
    $ftpUserName = $connectFtp->ftpUserName;
    $ftpPassword = $connectFtp->ftpPassword;
    $ftpSendFolder = $connectFtp->ftpSendFolder;
    $ftpResultFolder = $connectFtp->ftpResultFolder;
	$ftpArchiveFolder = $connectFtp->ftpArchiveFolder;
}else{
    $ftpServer = "";
    $ftpUserName = "";
    $ftpPassword = "";
    $ftpSendFolder = "";
    $ftpResultFolder = "";
	$ftpArchiveFolder = "";
}
echo "<div id='newFtpForm' style='display: none; padding-top: 4em;'>";
//setup the form for submission and validation
echo "<form id='smp2_ftp' action='index.php' method='get'>";
//start entering the fields to create the XML report
echo "<div class='row'>";
echo "<h3>FTP Connection Information</h3>";
echo "<p>Once a connection to the FTP Server is achieved you will not need to change this again.</p>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                <input class='input' type='text' placeholder='Enter FTP Server Name or IP Address' id='ftpServer' name='ftpServer' value='$ftpServer'/>
                  </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                    <input class='input' type='text' placeholder='Enter the FTP User Name' id='ftpUserName' name='ftpUserName' value='$ftpUserName'/>
                  </div>";
echo "</div>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                        <input class='input' type='password' placeholder='Enter FTP password' id='ftpPassword' name='ftpPassword' value='$ftpPassword'/>
                          </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                            <input class='input' type='text' placeholder='Enter the folder in which to send samples' id='ftpSendFolder' name='ftpSendFolder' value='$ftpSendFolder'/>
                          </div>";
echo "</div>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                            <input class='input' type='text' placeholder='Enter the folder in which to receive samples' id='ftpResultFolder' name='ftpResultFolder' value='$ftpResultFolder'/>
                          </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field no-icon'>
                            <input class='input' type='text' placeholder='Enter the folder in which to Archive samples ' id='ftpArchiveFolder' name='ftpArchiveFolder' value='$ftpArchiveFolder'/>
                          </div>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
echo "<div  class='medium rounded metro primary btn'><input id='submit_ftp' type='submit' value='Save Connection' /></div> ";
echo "<div  class='medium rounded metro primary btn'><input id='close_ftp' type='button' value='Close' /></div> ";
echo "<p>To check the folders for sending and results it may be necessary to connect via an FTP client.</p>";
echo "</div>";
echo "</form>";
echo "</div>"; //end div for newConnection Form
echo "<div class='row'>";
echo"<div id='ftpMessage'></div>";
echo "</div>";
?>
<script>
    $('#close_ftp').click(function(){
        $("#newFtpForm").delay(200).slideUp(900);
    });
    $('#smp2_ftp').validation({
        // pass an array of required field objects
        required: [
            {
                // name should reference a form inputs name attribute
                // just passing the name property will default to a check for a present value
                name: 'ftpServer',
                validate: function($e) {
                    return $e.val().length >0;
                }
            },
            {
                name: 'ftpUserName',
                validate: function($e) {
                    return $e.val().length >0;
                }
            },
            {
                name: 'ftpPassword',
                validate: function($e) {
                    return $e.val().length >0;
                }
            },
            {
                name: 'ftpSendFolder',
                validate: function($e) {
                    return $e.val().length >0;
                }
            },
            {
                name: 'ftpResultFolder',
                validate: function($e) {
                    return $e.val().length >0;
                }
            },
			{
				name: 'ftpArchiveFolder',
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
                url: 'library/classes/dbFtpCheck.Class.php',
                data: data,
                type: "POST",
                success: function(data) {

                    $("#ftpMessage").show();
                    $("#ftpMessage").html(data);
                    $("#ftpMessage").delay(1200).fadeOut(400);
                    $("#newFtpForm").delay(1800).slideUp(900);
                }
            });
        }
    });
</script>