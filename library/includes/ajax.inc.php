<?php
if(empty($_SESSION["sessionId"])){
	session_start();
}

?>
<script>

$("#newSample").click(function(){
	$.ajax({
		url: 'library/includes/statusCheck.inc.php',
		data: {sampleArray: "New"},
		type: "POST",
		success: function(data) {
			var objData = $.parseJSON(data);
			var status = objData[0].status;
			$.ajax({
				url: 'library/includes/setValidation.inc.php',
				data: {sampleStatus: status},
				type: "POST",
				success: function(data) {
					$("#samplesMessage").show();
					$("#samplesMessage").html(data);
				}
			});
			$.ajax({
				url: 'library/includes/display.inc.php',
				data: {},
				type: "POST",
				success: function(data) {
					$("#newsampleForm").html(data);
				}
			});
			$("#newsampleForm").slideDown(500);
		}
	});


});

$("#setconn").click(function(){
	$("#newConnectionForm").slideDown(900);
});

$("#setftp").click(function(){
	$("#newFtpForm").slideDown(900);
});

$("#setpw").click(function(){
	$("#passWordForm").slideDown(900);
});

$("#newTables").click(function(){
	$.ajax({
		url: 'library/includes/createSMP2Tables.inc.php',
		type: "POST",
		success: function(data) {
			$("#samplesMessage").show();
			$("#samplesMessage").html(data);
		}
	});
});

$("#viewSelected").click(function(){
	var samples=[];
	$("input[type=checkbox]:checked").each ( function() {
		samples.push( $(this).val() );
	});
	if(samples.length == 1) {
		$.ajax( {
		url: 'library/includes/statusCheck.inc.php',
		data: {sampleArray: samples},
		type: "POST",
			success: function(data) {
				var objData = $.parseJSON(data);
				var status = objData[0].status;
				$.ajax({
					url: 'library/includes/setValidation.inc.php',
					data: { sampleStatus: status},
					type: "POST",
					success: function(data) {
						$("#samplesMessage").show();
						$("#samplesMessage").html(data);
					}
				});

				$.ajax({

					url: 'library/includes/display.inc.php',
					data: {},
					type: "POST",
					success: function(data) {
						$("#newsampleForm").html(data);
					}
				});

				$("#newsampleForm").slideDown(900);
				$.ajax({
					url: 'library/includes/addValues.inc.php',
					data: { sampleArray: samples},
					type: "POST",
					success: function(data) {
						$("#samplesMessage").show();
						$("#samplesMessage").html(data);
					}
				});
			}
		});

	}else{
		alert("You must select only one Sample to view.");
	}
})

$("#deleteFTPFiles").click(function(){
	if(confirm("Are you sure you want to delete the selected files?")){
		var samples=[];
		$("input[type=checkbox]:checked").each ( function() {
			samples.push( $(this).val() );
		});
		if(samples.length > 0) {
			$.ajax({
				url: 'library/includes/deleteSamples.inc.php',
				data: { sampleArray: samples},
				type: "POST",
				success: function(data) {
					$("#samplesMessage").show();
					$("#samplesMessage").html(data);
					//$("#samplesMessage").delay(1800).fadeOut(400);
					//$("#samplesMessage").delay(1200).slideUp(900);
					$.ajax({
						type : 'GET',
						url : 'library/includes/show_samples.inc.php',
						dataType : 'html',
						success : function (response) {
							$("#viewSamples").html(response);
						}
					});
				}
			});
		}else{
			alert("Please select at least 1 sample to delete");
		}
	}
});

$("#sendFTP").click(function(){
	if(confirm("Are you sure you want to proceed?")){
		var samples=[];
		$("input[type=checkbox]:checked").each ( function() {
			samples.push( $(this).val() );
		});
		if(samples.length > 0) {
			$.ajax({
				url: 'library/includes/sendSamples.inc.php',
				data: { sampleArray: samples},
				type: "POST",
				success: function(data) {
					$("#samplesMessage").show();
					$("#samplesMessage").html(data);
					//$("#samplesMessage").delay(1800).fadeOut(400);
					//$("#samplesMessage").delay(1200).slideUp(900);
					$.ajax({
						type : 'GET',
						url : 'library/includes/show_samples.inc.php',
						dataType : 'html',
						success : function (response) {
							$("#viewSamples").html(response);
						}
					});
				}
			});
		}else{
			alert("Please select a sample to send to the remote server.");
		}
	}else{
		$("#samplesMessage").show();
		$("#samplesMessage").html("Files will not be sent");
		$("#samplesMessage").delay(1800).fadeOut(400);
	}
});

$("#checkResults").click(function(){
	if(confirm("Are you sure you want to check for any results?")){
		$.ajax({
			url: 'library/includes/checkForResults.inc.php',
			data: {check: true},
			type: "POST",
			success: function(data) {
				$("#samplesMessage").show();
				$("#samplesMessage").html(data);
				//$("#samplesMessage").delay(1800).fadeOut(400);
				//$("#samplesMessage").delay(1200).slideUp(900);
				$.ajax({
					type : 'GET',
					url : 'library/includes/show_samples.inc.php',
					dataType : 'html',
					success : function (response) {
						$("#viewSamples").html(response);
					}
				});
			}
		});
	}else{
		$("#samplesMessage").show();
		$("#samplesMessage").html("Results will not be checked");
		$("#samplesMessage").delay(1800).fadeOut(400);
	}
});

$("#accept").click(function(){
	checkPassword();
});

function checkPassword(){
	$.ajax({
		url: 'library/includes/checkPassword.inc.php',
		data: {check: $("#entry-password").val()},
		type: "POST",
		success: function(data) {
			$("#samplesMessage").show();
			$("#samplesMessage").html(data);
			$("#samplesMessage").delay(1800).fadeOut(400);
			setTimeout(function() {
				window.location.replace("index.php");
			}, 2000);

		}
	});
}

$("#entry-password").bind('keypress', function(e){
	var code = e.keyCode || e.which;
	if(code == 13) {
		checkPassword();
	}
});

$("#html_logout").click(function(){
	$.ajax({
		url: 'library/includes/logout.inc.php',
		type: "POST",
		success: function(data) {
			$("#samplesMessage").show();
			$("#samplesMessage").html(data);
			$("#samplesMessage").delay(1800).fadeOut(400);
			setTimeout(function() {
				window.location.replace("index.php");
			}, 1900);

		}
	});
});
</script>