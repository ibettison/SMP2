<?php
echo "<div id='newsampleForm' style='display: none; padding-top: 4em;'>";
//setup the form for submission and validation
echo "<form id='smp2_form' action='index.php' method='get'>";
//start entering the fields to create the XML report
echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='hubName'>Select Hub Name</label><br />
                <div class='picker'>
                    <select name='hubName'>
                        <option value='#' disabled selected     >Select Hub Name</option>
                        <option value='1 - Birmingham'>1 - Birmingham</option>
                        <option value='2 - Cardiff'>2 - Cardiff</option>
                        <option value='3 - Cambridge'>3 - Cambridge</option>
                        <option value='4 - Edinburgh'>4 - Edinburgh</option>
                        <option value='5 - Glasgow'>5 - Glasgow</option>
                        <option value='6 - Leeds'>6 - Leeds</option>
                        <option value='7 - Manchester'>7 - Manchester</option>
                        <option value='8 - Royal Marsden'>8 - Royal Marsden</option>
                        <option value='9 - Barts & Brighton'>9 - Barts & Brighton</option>
                        <option value='10 - Belfast'>10 - Belfast</option>
                        <option value='11 - Imperial'>11 - Imperial</option>
                        <option value='12 - KCL'>12 - KCL</option>
                        <option value='13 - Leicester'>13 - Leicester</option>
                        <option value='14 - Newcastle'>14 - Newcastle</option>
                        <option value='15 - Oxford'>15 - Oxford</option>
                        <option value='16 - Sheffield'>16 - Sheffield</option>
                        <option value='17 - Southampton'>17 - Southampton</option>
                        <option value='18 - UCL'>18 - UCL</option>
                    </select>

                </div>";
                echo "</li></ul>";
        echo "</div>";
    echo "</div>";
echo "<div style='clear:both;'></div>";

echo "<div class='row'>";
    echo "<h3>Patient Information</h3>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'>
            <input class='input' type='text' placeholder='Enter the Organisation Code' name='organisationCode'/>
        </div>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'>
            <input class='input' type='text' placeholder='Enter the Patient Identifier' name='localPatientIdentifier'/>
        </div>";
        echo "</div>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'>
            <input class='input' type='text' placeholder='Enter the Oncologists Initials' name='treatingOncologistInitials'/>
        </div>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'>
            <input class='input' type='text' placeholder='Enter the Patients Age' name='ageAtAttendance'/>
        </div>";
        echo "</div>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
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
            </li></ul>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
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
            </li></ul>";
        echo "</div>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
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
            </li></ul>";
        echo "</div>";

    echo "<div class='six columns'>";
        echo "<div class='field no-icon'><br />
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
    echo "<ul><li class='field'>
            <label class='inline' for='cancerTreatmentModality'>Select Treatment Types (Hold Ctrl to select multiple treatments)</label><BR />
            <div class='picker'>";
                echo "<select style='height:27.6em;' id='cancerTreatmentModality' name='cancerTreatmentModality[]'  multiple='multiple'>";
                    foreach($treatments as $treatment){
                    echo "<option>".$treatment."</option>";
                    }
                    echo "</select>";
                echo "</div>";
            echo "</li></ul>";
    echo "</div>";


echo "<div class='row'>";
    echo "<ul><li class='field'>
            <label class='inline' for='performanceStatus'>Select the patients performance status (WHO)</label>
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
        </li></ul>";
    echo "</div>";

echo "<div class='row'>";
    echo "<h3>Sample Information</h3>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'><BR />
            <input class='input' type='text' placeholder='Enter the Sample ID' name='sourceSampleIdentifier'/>
        </div>
    </div>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='originOfSample'>Select the origin of the Sample</label>
                <div class='picker'>
                    <select name='originOfSample'>
                        <option value='#' disabled selected>Select sample Origin</option>
                        <option value='1'>Primary tumor</option>
                        <option value='2'>Metastic site - Lymph node</option>
                        <option value='3'>Metastic site - Other</option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "</div>";
echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='typeOfSample'>Select the type of sample</label>
                <div class='picker'>
                    <select name='typeOfSample'>
                        <option value='#' disabled selected>Select type of sample</option>
                        <option value='1'>1 - Blood</option>
                        <option value='3'>3 - Tissue- Resection</option>
                        <option value='8'>8 - Tissue- Bronchoscopic biopsy</option>
                        <option value='9'>9 - Tissue- CT guided biopsy</option>
                        <option value='10'>10 -Tissue- Surgical biopsy</option>
                        <option value='11'>11 - Tissue- Other biopsy</option>
                        <option value='12'>12 - Cytology cell block- EBUS/EUS FNA</option>
                        <option value='13'>13 - Cytology cell block- Bronchoscopic washing</option>
                        <option value='14'>14 - Cytology cell block- CT guided</option>
                        <option value='15'>15 - Cytology cell block- Effusion</option>
                        <option value='16'>16 - Cytology cell block- Other</option>
                        <option value='17'>17 - Extracted DNA</option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='procedureToObtainSample'>Select the procedure for obtaining the sample</label>
                <div class='picker'>
                    <select name='procedureToObtainSample'>
                        <option value='#' disabled selected>Select the procedure </option>
                        <option value='1'>1 - CT guided biopsy</option>
                        <option value='2'>2 - US guided biopsy</option>
                        <option value='3'>3 - Surgical lung biopsy</option>
                        <option value='4'>4 - Surgical resection</option>
                        <option value='5'>5 - EBUS</option>
                        <option value='6'>6 - EUS</option>
                        <option value='7'>7 - Other biopsy</option>
                        <option value='8'>8 - Other FNA cytology</option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='typeOfBiopsy'>Select the Type of Biopsy</label>
                <div class='picker'>
                    <select name='typeOfBiopsy'>
                        <option value='#' disabled selected>Select type of Biopsy</option>
                        <option value='0'>0 - unknown</option>
                        <option value='1'>1 - Diagnostic biopsy</option>
                        <option value='2'>2 - Repeat biopsy due to sample test failure</option>
                        <option value='3'>3 - Repeat biopsy due to lack of sample after local testing</option>
                        <option value='4'>4 - Mandatory repeat biopsy after targeted first line therapy</option>
                        <option value='5'>5 - Repeat biopsy due to non actionable mutation in diagnostic biopsy</option>
                        <option value='6'>6 - Voluntary repeat biopsy after first line therapy</option>
                        <option value='7'>7 - Voluntary repeat biopsy after targetted therapy </option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'><BR />
            <input class='input' type='date' placeholder='Enter the Date the sample was taken (YYYY-MM-DD)' name='dateSampleTaken'/>
        </div>
    </div>";
echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='tumourType'>Select the tumor type</label><BR />
                <div class='picker'>
                    <select name='tumourType'>
                        <option value='#' disabled selected>Select tumor type</option>
                        <option value='1'>1 - Breast</option>
                        <option value='2'>2 - Colorectal</option>
                        <option value='3'>3 - Lung</option>
                        <option value='4'>4 - Melanoma</option>
                        <option value='5'>5 - Ovarian</option>
                        <option value='6'>6 - Prostate</option>
                        <option value='7'>7 - Other</option>
                    </select>
                </div>
            </li></ul>";
    echo "</div>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'><BR />
            <input class='input' type='text' placeholder='Enter the Morphology SNOMED' name='morphologySnomed'/>
        </div>
    </div>";
echo "</div>";


echo "<div class='row'>";
    echo "<ul><li class='field'>
            <label class='inline' for='pathologyTCategory'>Select the pathology T Category</label><BR />
            <div class='picker'>
                <select name='pathologyTCategory'>
                    <option value='#' disabled selected>Select T Category</option>
                    <option value='0'>0 - unknown</option>
                    <option value='TX'>TX - Primary tumour cannot be assessed</option>
                    <option value='T0'>T0 - No evidence of primary tumour</option>
                    <option value='Tis'>Tis - Carcinoma in situ</option>
                    <option value='T1a'>T1a - Tumour ≤20 mm diameter</option>
                    <option value='T1b'>T1b - Tumour >20–≤30 mm</option>
                    <option value='T2'>T2 - Tumour >= 20mm from the carina, invades visceral pleura, partial atelectasis</option>
                    <option value='T2a'>T2a - >30–≤50 mm</option>
                    <option value='T2b'>T2b - >50–≤70 mm</option>
                    <option value='T3'>T3 - >70 mm; involvement of parietal pleura, mediastinal pleura, chest wall, pericardium or
                        diaphragm; tumour within 20 mm of the carina; atelectasis/obstructive pneumonitis
                        involving whole lung; separate nodule(s) in the same lobe</option>
                    <option value='T4'>T4 - Involvement of great vessels, mediastinum, carina, trachea, oesophagus, vertebra, or heart
                        Separate tumour nodule(s) in different ipsilateral lobe</option>
                    <option value='9'>9 - Not applicable</option>
                </select>
            </div>
        </li></ul>";
echo "</div>";

echo "<div class='row'>";
    echo "<ul><li class='field'>
            <label class='inline' for='pathologyNCategory'>Select the pathology N Category</label><BR />
            <div class='picker'>
                <select name='pathologyNCategory'>
                    <option value='#' disabled selected>Select N Category</option>
                    <option value='0'>0 - unknown </option>
                    <option value='NX'>NX - Regional lymph nodes cannot be assessed</option>
                    <option value='N0'>N0 - No regional node involvement</option>
                    <option value='N1'>N1 - Ipsilateral hilar/intrapulmonary nodes (node stations 10–14)</option>
                    <option value='N2'>N2 - Ipsilateral mediastinal nodes (node stations 1–9)</option>
                    <option value='N3'>N3 - Contralateral mediastinal, hilar, ipsilateral or contralateral scalene, supraclavicular nodes</option>
                    <option value='9'>9 - not applicable</option>
                </select>
            </div>
        </li></ul>";
echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='pathologyMCategory'>Select the pathology M Category</label>
                <div class='picker'>
                    <select name='pathologyMCategory'>
                        <option value='#' disabled selected>Select M Category</option>
                        <option value='0'>0 - unknown</option>
                        <option value='M0'>M0 - No distant metastasis</option>
                        <option value='M1'>M1 - Distant metastasis</option>
                        <option value='M1a'>M1a - Separate tumour nodule(s) in a contralateral lobe; pleural nodules or malignant pleural or pericardial effusion.</option>
                        <option value='M1b'>M1b - Distant metastasis</option>
                        <option value='9'></option>
                    </select>
                </div>
            </li></ul>";
    echo "</div>";
    echo "<div class='six columns'>";
        echo "<div class='field no-icon'><BR />
            <input class='input' type='text' placeholder='Enter the TNM Stage Grouping' name='integratedTNMStageGrouping'/>
            </div>
        </div>";
    //echo "</div>";
echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='alkStatus'>Select the ALK IHC Status</label><BR />
                <div class='picker'>
                    <select name='alkStatus'>
                        <option value='#' disabled selected>Select ALK IHC Status</option>
                        <option value='P'>P-positive</option>
                        <option value='N'>N-negative</option>
                        <option value='E'>E-equivocal</option>
                        <option value='X'>X-not known</option>
                        <option value='Z'>Z-not performed</option>
                        <option value='U'>U-technically unsatisfactory</option>
                    </select>
                </div>
            </li></ul>";
    echo "</div>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='egfrStatus'>Select the EGFR Status</label><br/>
                <div class='picker'>
                    <select name='egfrStatus'>
                        <option value='#' disabled selected>Select the EGFR</option>
                        <option value='M'>M-mutation detected</option>
                        <option value='N'>N-no mutation detected</option>
                        <option value='X'>X-not known</option>
                        <option value='F'>F-test failure</option>
                        <option value='Z'>Z-not performed</option>
                        <option value='Y'>Y-other result</option>
                    </select>
                </div>
            </li></ul>";
    echo "</div>";
echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='alkFishStatus'>Select the ALK FISH Status</label><BR />
                <div class='picker'>
                    <select name='alkFishStatus'>
                        <option value='#' disabled selected>Select ALK FISH Status</option>
                        <option value='R'>R-rearrangenent detected</option>
                        <option value='N'>N-no rearrangenent detected</option>
                        <option value='X'>X-not known</option>
                        <option value='F'>F-test failure</option>
                        <option value='Z'>Z-not performed</option>
                        <option value='Y'>Y-other result</option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "<div class='six columns'>";
        echo "<ul><li class='field'>
                <label class='inline' for='krasStatus'>Select the KRAS Status</label><br/>
                <div class='picker'>
                    <select name='krasStatus'>
                        <option value='#' disabled selected>Select the KRAS</option>
                        <option value='M'>M-mutation detected</option>
                        <option value='N'>N-no mutation detected</option>
                        <option value='X'>X-not known</option>
                        <option value='F'>F-test failure</option>
                        <option value='Z'>Z-not performed</option>
                        <option value='Y'>Y-other result</option>
                    </select>
                </div>
            </li></ul>";
        echo "</div>";
    echo "</div>";

echo "<div class='row'>";
    echo "<div class='six columns'>";

        echo "<div class='field no-icon'>
            <input class='input' type='text' placeholder='Enter the date the sample was sent (YYYY-MM-DD)' name='dateSampleSent'/>
        </div>
    </div>";
echo "</div>";

echo "<div class='row'>";
    echo "<div  class='medium rounded metro primary btn'><input id='submit_button' type='submit' value='Save Sample' /></div>";
    echo "</div>";
echo "</form>";
echo "<div class='row'>";
    echo "<div id='message_area'></div>";
    echo "</div>";

echo "</div>"; //end div of newsampleform
