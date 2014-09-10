<?php

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
        $status = "Not sent";
        $statusChanged = "";
        }else{
        $status = $statusValue[0]["status"];
        $statusChanged = "[".$statusValue[0]["datechanged"]."]";
        }
        echo "<tr>";
            echo "<td><li class='field'>
                    <input name='checkbox[]' id='check1' type='checkbox'>
                    <span</span></li></td>
            <td>".$sample["dateSampleSent"]."</td><td>".$sample["sourceSampleIdentifier"]."</td><td>".$sample["localPatientIdentifier"]."</td><td>$status<p  style='font-size:10px;'>$statusChanged</p></td>";
            echo "</tr>";
        }
        }else{
        echo "<tr><td>There are no samples to send, please add new samples.</td></tr>";
        }

        echo "</tbody>";
        echo "</thead>";
        echo "</table>";
echo "</div>";