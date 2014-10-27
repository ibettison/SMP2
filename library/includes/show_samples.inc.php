<?php
if(!defined("ROOT_FOLDER")){
    $root = $_SERVER["DOCUMENT_ROOT"];
    define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."/SMP2/library/includes/mysqli_datalayer.php");
$connect = json_decode(file_get_contents(ROOT_FOLDER."/SMP2/library/includes/connection.json"));
if(!$conn = dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
    echo("Cannot connect to the database");
}
echo "<div class='row'>";
    echo "<table class='rounded striped'>";
        echo "<thead>";
        echo "<th>Select</th>
        <th>Sample Sent</th>
        <th>Sample ID</th>
        <th>Patient ID</th>
        <th>Status</th>";
        echo "<tbody>";
        $sql = "select * from smp2_samples as s
        join smp2_patient_samples as ps on (s.s_id=ps.samples_id)
        join smp2_patients as p on (p.p_id=ps.patients_id)
        order by dateSampleSent, sourceSampleIdentifier";
        $samples = dl::getQuery($sql);
        if(!empty($samples)){
            foreach($samples as $sample){
                $statusValue = dl::select("smp2_status", "samples_id = ".$sample["s_id"]);
                if(empty($statusValue)){
                    $statusVal="";
                }else{
                    $statusVal = $statusValue[0]["status"];
                }
                switch($statusVal) {
                    case "Sent to TH":
                        $icon = "&#128228"; // uploaded icon
                        $colour = "#EBBF7A";
                        break;
                    case "Results Received":
                        $icon = "&#128229"; // downloaded icon
                        $colour = "#FCAD00";
                        break;
					case "Ready to Archive":
						$icon = "&#9873"; // downloaded icon
						$colour = "#665CD1";
						break;
                    case "Archived":
                        $icon = "&#10003"; // tick icon
                        $colour = "#2FE035";
                        break;
                    default:
                        $icon = "&#10060"; // cross icon
                        $colour = "#CF1A11";
                }
                if(empty($statusValue)){
                    $status = "<span style='color:$colour;'>".$icon."</span> Not sent";
                    $statusChanged = "";
                }else{
                    $status = "<span style='color:$colour;'>".$icon."</span> ".$statusValue[0]["status"];
                    $statusChanged = "[".$statusValue[0]["datechanged"]."]";
                }
                echo "<tr class='checkboxTable'>";
                    echo "<td class='checkboxTable'><li class='field'>
                    	<label class='checkbox' for='check1'>
                            <input name='sampleCheck[]' id='check1' type='checkbox' value='".$sample['sourceSampleIdentifier']."'>
                            <span></span></li></td>
                        </label>
                    <td class='checkboxTable'>".$sample["dateSampleSent"]."</td><td class='checkboxTable'>".$sample["sourceSampleIdentifier"]."</td><td class='checkboxTable'>".$sample["localPatientIdentifier"]."</td><td class='checkboxTable'>$status<p  style='font-size:10px;'>$statusChanged</p></td>";
                    echo "</tr>";
            }
        }else{
            echo "<tr><td>There are no samples to send, please add new samples.</td></tr>";
        }

        echo "</tbody>";
        echo "</thead>";
        echo "</table>";
echo "</div>";
dl::closedb();