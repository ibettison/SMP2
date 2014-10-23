<?php
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}

try {
	if (file_exists(ROOT_FOLDER . "/SMP2/library/includes/connection.json")) {
		include_once(ROOT_FOLDER . "/SMP2/library/includes/mysqli_datalayer.php");
		$connect = json_decode(file_get_contents(ROOT_FOLDER . "/SMP2/library/includes/connection.json"));
		if (!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
			throw new Exception("Cannot connect to the database");
		}else{
			$security_settings 				= dl::select("smp2_security");
			if(!empty($security_settings)){
				$pwSalt 					= $security_settings[0]["sec_salt"];
			}else{
				$pwSalt 					= "";
				$pwPassword 				= "";
				$pwPass 					= "";
			}
		}
	} else {
		throw new Exception("The connection to the database needs to be established before a password can be created.");
	}
} catch (Exception $e) {
	echo($e->getMessage());
}

echo "<div id='passWordForm' style='display: none; padding-top: 4em;'>";
//setup the form for submission and validation
echo "<form id='smp2_password' action='index.php' method='post'>";
//start entering the fields to create the XML report
echo "<div class='row'>";
echo "<h3>Set/Reset Password</h3>";
echo "<p>You can create a new password or reset an existing password here.</p>";
echo "</div>";
if(empty($pwSalt)){ //only want to set the salt once and once it has been validated and saved then never change it
	echo "<div class='row'>";
		echo "<div class='six columns'>";
		echo "<div class='field no-icon'>
						<input style='width: 95%;' class='input' type='text' placeholder='Enter a 22 character salt to intialise the security procedure' id='pwSalt' name='pwSalt'/> <span id='lenCount' class='adjoined'>0</span>
						  </div>";
		echo "</div>";

	echo "</div>";
}else{
	//if the salt exists it is displayed as hidden so it cannot be changed but still validated
	echo "<div class='row'>";
	echo "<div class='six columns'>";
	echo "<div class='field no-icon'>
						<input style='width: 95%;' class='input' type='text' placeholder='Enter a 22 character salt to intialise the security procedure' id='pwSalt' name='pwSalt' value='$pwSalt'
						hidden/>
						  </div>";
	echo "</div>";

	echo "</div>";
	echo "<div class='row'>";
	echo "<div class='six columns'>";
	echo "<div class='field no-icon'>
						<input class='input' type='password' placeholder='Enter your Old password' id='pwOldPassword' name='pwOldPassword' />
					  </div>";
	echo "</div>";
	echo "</div>";

}
echo "<div class='row'>";
	echo "<div class='six columns'>";
	echo "<div class='field no-icon'>
						<input class='input' type='password' placeholder='Enter a password' id='pwPassword' name='pwPassword'/>
					  </div>";
	echo "</div>";
echo "</div>";

echo "<div class='row'>";
	echo "<div class='six columns'>";
	echo "<div class='field no-icon'>
							<input class='input' type='password' placeholder='Confirm the password' id='pwPass' name='pwPass'/>
							  </div>";
	echo "</div>";
echo "</div>";


echo "<div class='row'>";
echo "<div  class='medium rounded metro primary btn'><a href='#' id='submit_pw'>Save Password</a></div> ";
echo " <div  class='medium rounded metro primary btn'><a href='#' id='pw_close'>Close</a></div>";
echo "</div>";
echo "</form>";
echo "</div>"; //end div Form
echo "<div class='row'>";
echo"<div id='pwMessage'></div>";
echo "</div>";
?>
<script>

	$("#pw_close").click(function(){
		$("#passWordForm").delay(200).slideUp(900);
	});

	$("#pwSalt").bind('keypress', function(){
		var lenSalt = ($("#pwSalt").val().length) + 1;
		$("#lenCount").html(lenSalt);
	});

	$("#submit_pw").click(function(){
		$("#smp2_password").submit();
	});
	$('#smp2_password').validation({
		// pass an array of required field objects
		required: [
			{
				// name should reference a form inputs name attribute
				// just passing the name property will default to a check for a present value
				name: 'pwSalt',
				validate: function($e) {
					return $e.val().length == 0 || $e.val().length  == 22;
				}
			},
			{
				name: 'pwPassword',
				validate: function($e) {
					return $e.val().length !== 0 && $e.val().length >=5;
				}
			},
			{
				name: 'pwPass',
				validate: function($e) {
					return $e.val() == $("#pwPassword").val();
				}
			}
		],
		// callback for failed validation on form submit
		fail: function() {
			alert("Form validation failed");
			Gumby.error('Form validation failed');
		},
// callback for successful validation on form submit
// if omitted, form will submit normally
		submit: function(data) {
			alert("Password Validated");
			$.ajax({
				url: 'library/includes/pwWrite.inc.php',
				data: data,
				type: "POST",
				success: function(data) {

					$("#pwMessage").show();
					$("#pwMessage").html(data);
					$("#pwMessage").delay(1200).fadeOut(900);
					$("#passWordForm").delay(1800).slideUp(900);
				}
			})
		}
	});

</script>