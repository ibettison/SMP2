<script>

$("#newSample").click(function(){
	resetForm($("#newsampleForm"));
	var valType = "initial";
	$.ajax({
		url: 'library/includes/setValidation.inc.php',
		data: {valType: valType},
		type: "POST",
		success: function(data) {
			$("#samplesMessage").show();
			$("#samplesMessage").html(data);
		}
	});
	$("#newsampleForm").slideDown(900);
});

function resetForm($form) {
	$form.find('select').val('#');
	$form.find('input:text, input:password, input:file, textarea').val('');
	$form.find('input:radio, input:checkbox')
		.removeAttr('checked').removeAttr('selected');
}

$("#newSampleClose").click(function(){
	$("#newsampleForm").slideUp(900);
});

$("#close-display").click(function(){
	$("#newsampleForm").slideUp(400);
});

$("#setconn").click(function(){
	$("#newConnectionForm").slideDown(900);
});

$("#setftp").click(function(){
	$("#newFtpForm").slideDown(900);
});

$("#viewSelected").click(function(){
	var valType = "edit";
	$.ajax({
		url: 'library/includes/setValidation.inc.php',
		data: { valType: valType},
		type: "POST",
		success: function(data) {
			$("#samplesMessage").show();
			$("#samplesMessage").html(data);
		}
	});
	var samples=[];
	$("input[type=checkbox]:checked").each ( function() {
		samples.push( $(this).val() );
	});
	if(samples.length == 1) {
		$("#newsampleForm").slideDown(1200);
		$.ajax({
			url: 'library/includes/addValues.inc.php',
			data: { sampleArray: samples},
			type: "POST",
			success: function(data) {
				$("#samplesMessage").show();
				$("#samplesMessage").html(data);
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
					$("#samplesMessage").delay(1800).fadeOut(400);
					$("#samplesMessage").delay(1200).slideUp(900);
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

</script>