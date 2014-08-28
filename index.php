
<?php
include("header.inc");
include("library/mysqli_datalayer.php");
include("library/connection.php");
echo "<div class='topbox'>";
echo "<div class='row'>";
    echo "<div class='twelve columns special head'><h1>SMP2 Project</h1>
    <h3><span>Sponsored by the <span>CRUK </span> and Newcastle University</span></h3>
    </div>";
echo "</div></div>";
//start entering the fields to create the XML report
echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<li class='field'>
    <label class='inline' for='hubName'>Select Hub Name</label><br />
    <div class='picker'>
    <select name='hubName'>
    <option value='#' disabled selected>Select Hub Name</option>
    <option value='1'>1 - Birmingham</option>
    <option value='2'>2 - Cardiff</option>
    <option value='3'>3 - Cambridge</option>
    <option value='4'>4 - Edinburgh</option>
    <option value='5'>5 - Glasgow</option>
    <option value='6'>6 - Leeds</option>
    <option value='7'>7 - Manchester</option>
    <option value='8'>8 - Royal Marsden</option>
    <option value='9'>9 - Barts & Brighton</option>
    <option value='10'>10 - Belfast</option>
    <option value='11'>11 - Imperial</option>
    <option value='12'>12 - KCL</option>
    <option value='13'>13 - Leicester</option>
    <option value='14'>14 - Newcastle</option>
    <option value='15'>15 - Oxford</option>
    <option value='16'>16 - Sheffield</option>
    <option value='17'>17 - Southampton</option>
    <option value='18'>18 - UCL</option>
    </select>

        </div>";
echo "</li>";
echo "</div>";
echo "</div>";
echo "<div style='clear:both;'></div>";

echo "<div class='row'>";
    echo "<h3>Patient Information</h3>";
echo "</div>";

echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field'>
          <input class='input' type='text' placeholder='Enter the Organisation Code' name='organisationCode'/>
        </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field'>
          <input class='input' type='text' placeholder='Enter the Patient Identifier' name='localPatientIdentifier'/>
        </div>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<div class='field'>
          <input class='input' type='text' placeholder='Enter the Oncologists Initials' name='treatingOncologistInitials'/>
        </div>";
echo "</div>";
echo "<div class='six columns'>";
echo "<div class='field'>
          <input class='input' type='text' placeholder='Enter the Patients Age' name='ageAtAttendance'/>
        </div>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<li class='field'>
    <label class='inline' for='genderCode'>Select Gender</label><br />
    <div class='picker'>
    <select name='genderCode'>
    <option value='#' disabled selected>Select Gender</option>
    <option value='0'>0 - Not Known</option>
    <option value='1'>1 - Male</option>
    <option value='2'>2 - Female</option>
    <option value='9'>9 - Not specified</option>
    </select>
    </div>
        </li>";
echo "</div>";
echo "<div class='six columns'>";
echo "<li class='field'>
           <label class='inline' for='ethnicCategory'>Select Ethnicity</label>
    <div class='picker'>
    <select name='ethnicCategory'>
    <option value='#' disabled selected>Select Ethnicity</option>
    <option value='A'>A - White British</option>
    <option value='B'>B - White Irish</option>
    <option value='C'>C - Any other White Background Mixed</option>
    <option value='D'>D - White and Black Caribbean</option>
    <option value='E'>E - White and Black African</option>
    <option value='F'>F - White and Asian</option>
    <option value='G'>G - Any other mixed background Asian or Asian British</option>
    <option value='H'>H - Indian</option>
    <option value='J'>J - Pakistani</option>
    <option value='K'>K - Bangladeshi</option>
    <option value='L'>L - Any other Asian background Black or Black British</option>
    <option value='M'>M - Caribbean</option>
    <option value='N'>N - African</option>
    <option value='P'>P - Any other Black Background Chinese or Other Ethnic Group</option>
    <option value='R'>R - Chinese</option>
    <option value='S'>S - Any other ethnic group</option>
    <option value='Z'>Z - Not stated</option>
    <option value='99'>99 - Not known</option>
    </select>
    </div>
    </li>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
echo "<div class='six columns'>";
echo "<li class='field'>
          <label class='inline' for='smokingStatus'>Select Smoking Status</label>
    <div class='picker'>
    <select name='smokingStatus'>
    <option value='#' disabled selected>Select Smoking Status</option>
    <option value='1'>1 - Current smoker</option>
    <option value='2'>2 - Ex smoker</option>
    <option value='3'>3 - Non-smoker - history unknown</option>
    <option value='4'>4 - Never smoked</option>
    <option value='Z'>Z - Not stated (PERSON asked but declined to provide a response)</option>
    <option value='99'>99 - Not known</option>
    </select>
    </div>
    </li>";
echo "</div>";

echo "<div class='six columns'>";
echo "<div class='field'><br />
          <input class='input' type='text' placeholder='Enter the No. of Prior Therapy Lines (0,1,2,3,4,N/K,N/A)' name='noOfPriorLinesTherapy'/>
        </div>";
echo "</div>";
echo "</div>";

echo "<div class='row'>";
$treatments = array("01 - Surgery","02 - Anti-cancer drug regimen (Cytotoxic Chemotherapy)","03 - Anti-cancer drug regimen (Hormone therapy)",
    "04 - Chemoradiotherapy",
    "05 - Teletherapy (Beam Radiation excluding Proton Therapy)",
    "06 - Brachytherapy",
    "07 - Specialist Palliative Care",
    "08 - Active Monitoring (excluding non-specialist Palliative Care)",
    "09 - Non-specialist Palliative Care (excluding Active Monitoring)",
    "10 - Radio Frequency Ablation (RFA)",
    "11 - High Intensity Focussed Ultrasound (HIFU)",
    "12 - Cryotherapy",
    "13 - Proton Therapy",
    "14 - Anti-cancer drug regimen (other)",
    "15 - Anti-cancer drug regimen (Immunotherapy)",
    "16 - Light Therapy (including Photodynamic Therapy and Psoralen and Ultra Violet A (PUVA) Therapy)",
    "17 - Hyperbaric Oxygen Therapy",
    "19 - Radioisotope Therapy (including Radioiodine)",
    "20 - Laser Treatment (including Argon Beam therapy)",
    "21 - Biological Therapies (excluding Immunotherapy)",
    "22 - Radiosurgery",
    "97 - Other Treatment",
    "98 - All treatment declined");
echo "<li class='field'>
        <label class='inline' for='cancerTreatmentModality'>Select Treatment Types</label><BR />
        <div class='picker'>";
echo "<select style='height:8.6em;' id='cancerTreatmentModality' name='cancerTreatmentModality[]'  multiple='multiple'>";
foreach($treatments as $treatment){
    echo "<option>".$treatment."</option>";
}
echo "</select>";
echo "</div>";
echo "</li>";
echo "</div>";


echo "<div class='row'>";
echo "<div class='six columns'>";
    echo "<li class='field'>
            <label class='inline' for='smokingStatus'>Select Smoking Status</label>
            <div class='picker'>
                <select name='smokingStatus'>
                    <option value='#' disabled selected>Select Smoking Status</option>
                    <option value='1'>1 - Current smoker</option>
                    <option value='2'>2 - Ex smoker</option>
                    <option value='3'>3 - Non-smoker - history unknown</option>
                    <option value='4'>4 - Never smoked</option>
                    <option value='Z'>Z - Not stated (PERSON asked but declined to provide a response)</option>
                    <option value='99'>99 - Not known</option>
                </select>
            </div>
          </li>";
echo "</div>";
echo "<div class='six columns'>";
echo "<li class='field'>
    <label class='inline' for='performanceStatus'>Select the patients movement status</label>
    <div class='picker'>
    <select name='performanceStatus'>
    <option value='#' disabled selected>Select movement status</option>
    <option value='0'>0 - Able to carry out all normal activity without restriction</option>
    <option value='1'>1 - Restricted in physically strenuous activity, but able to walk and do light work</option>
    <option value='2'>2 - Able to walk and capable of all self care, but unable to carry out any work. Up and about more than 50% of waking hours</option>
    <option value='3'>3 - Capable of only limited self care, confined to bed or chair more than 50% of waking hours</option>
    <option value='4'>4 - Completely disabled. Cannot carry on any self care. Totally confined to bed or chair</option>
    <option value='9'>9 - Not recorded</option>
    </select>
</div>
      </li>";
echo "</div>";
echo "</div>";



