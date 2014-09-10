<script>
$("#newSample").click(function(){
    $("#newsampleForm").slideDown(900);
});
$("#setconn").click(function(){
    $("#newConnectionForm").slideDown(900);
});
$("#setftp").click(function(){
    $("#newFtpForm").slideDown(900);
});
// initialize plugin
$('#smp2_form').validation({
    // pass an array of required field objects
    required: [
        {
            // name should reference a form inputs name attribute
            // just passing the name property will default to a check for a present value
            name: 'hubName',
            validate: function($e) {
                return $e.val() !== null;
            }
        },
        {
            name: 'organisationCode',
            validate: function($e) {
                return $e.val().length <= 5 & $e.val().length >0;
            }
        },
        {
            name: 'localPatientIdentifier',
            validate: function($e) {
                return $e.val().length <= 10 & $e.val().length >0;
            }
        },
        {
            name: 'treatingOncologistInitials',
            validate: function($e) {
                return $e.val().length <= 3;
            }
        },
        {
            name: 'ageAtAttendance',
            validate: function($e) {
                if($e.val().length >0) {
                    return $.isNumeric($e.val()) & $e.val().length <= 3 & $e.val() <=110;
                }else{
                    return true;
                }
            }
        },
        {
            name: 'genderCode',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'ethnicCategory',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'noOfPriorLinesTherapy',
            validate: function($e) {
                if($e.val().length >0) {
                    switch ($e.val()){
                        case "0":
                        case "1":
                        case "2":
                        case "3":
                        case "4":
                        case "N/K":
                        case "N/A":
                            return true;
                            break;
                        default:
                            return false;
                    }
                }else{
                    return true;
                }
            }
        },
        {
            name: 'sourceSampleIdentifier',
            validate: function($e) {
                return $e.val().length <= 20 & $e.val().length >0;
            }
        },
        {
            name: 'dateSampleTaken',
            validate: function($e) {
                return $e.val().match(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/);
            }
        },
        {
            name: 'dateSampleSent',
            validate: function($e) {
                return $e.val().match(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/);
            }
        },
        {
            name: 'smokingStatus',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'cancerTreatmentModality',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'performanceStatus',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'procedureToObtainSample',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'originOfSample',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'typeOfSample',
            validate: function($e) {
                return $e.val() !== null;
            }
        },
        {
            name: 'morphologySnomed',
            validate: function($e) {
                return $e.val().length >0 & $e.val().length <=18;
            }
        },
        {
            name: 'typeOfBiopsy',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'tumorType',
            validate: function($e) {
                return $e.val() !== null;
            }
        },
        {
            name: 'pathologyTCategory',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'pathologyNCategory',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'pathologyMCategory',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'integratedTNMStageGrouping',
            validate: function($e) {
                if($e.val().length >0) {
                    return $e.val().length <= 5;
                }else{
                    return true;
                }
            }
        },
        {
            name: 'alkStatus',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'egfrStatus',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'alkFishStatus',
            validate: function($e) {
                return $e.val() !== "#";
            }
        },
        {
            name: 'krasStatus',
            validate: function($e) {
                return $e.val() !== "#";
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
    $.ajax({
        url: 'library/classes/dbWrite.Class.php',
        data: data,
        type: "POST",
        success: function(data) {
            alert("Sample Added...");
            $("#message_area").html(data);
            $("#message_area").delay(1800).fadeOut(400);
            $("#newsampleForm").delay(1200).slideUp(900);
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
}
});

</script>