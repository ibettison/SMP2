<?php
if(session_id() == ''){
	session_start();
}
error_reporting(E_ALL);
if(!defined("ROOT_FOLDER")){
	$root = $_SERVER["DOCUMENT_ROOT"];
	define('ROOT_FOLDER', $root);
}
include_once(ROOT_FOLDER."SMP2/library/includes/mysqli_datalayer.php");
$connect 		= json_decode(file_get_contents(ROOT_FOLDER."SMP2/library/includes/connection.json"));
if(!$conn 		= dl::connect($connect->dbServer, $connect->dbUserName, $connect->dbPass, $connect->dbName)) {
	die("Cannot connect to the database");
}
$checkSample 	= dl::select("smp2_sample_results", "sourceSampleIdentifier = '".$_POST["sample"]."'" );
if(!empty($checkSample)){
	echo "<div class='row'>";
		echo "<H2>Sample Results</H2>";
		echo "</div>";
		echo "<div class='row'>";
		echo "<div class='three columns'>";
		echo "<label class='inline' for=''>Sample ID</label> ";
		echo "<div class='field no-icon'>
				<input class='input' type='text' value='".$checkSample[0]["sourceSampleIdentifier"]."' disabled />
			</div>
		</div>";
		echo "<div class='three columns'>";
		echo "<label class='inline' for=''>Date Received Sample</label> ";
		echo "<div class='field no-icon'>
				<input class='input' type='text' value='".$checkSample[0]["dateSampleReceived"]."' disabled />
			</div>
		</div>";
		echo "<div class='three columns'>";
		echo "<label class='inline' for=''>Lab Sample ID</label> ";
		echo "<div class='field no-icon'>
				<input class='input' type='text' value='".$checkSample[0]["labSampleIdentifier"]."' disabled />
			</div>
		</div>";
		echo "<div class='three columns'>";
		echo "<label class='inline' for=''>Date Report Released</label> ";
		echo "<div class='field no-icon'>
				<input class='input' type='text' value='".$checkSample[0]["reportReleaseDate"]."' disabled />
			</div>
		</div>";
	echo "</div>";
	echo "<div class='row'>";
		echo "<div class='four columns'>";
		echo "<label class='inline' for=''>Banked Nucleic Acid (Volume)</label> ";
		echo "<div class='field no-icon'>
					<input class='input' type='text' value='".$checkSample[0]["volumeBankedNucleicAcid"]."' disabled />
				</div>
			</div>";
		echo "<div class='four columns'>";
		echo "<label class='inline' for=''>Banked Nucleic Acid (Concentration)</label> ";
		echo "<div class='field no-icon'>
					<input class='input' type='text' value='".$checkSample[0]["concentrationBankedNucleicAcid"]."' disabled />
				</div>
			</div>";
		echo "<div class='four columns'>";
		echo "<label class='inline' for=''>Banked Nucleic Acid (Identifier)</label> ";
		echo "<div class='field no-icon'>
					<input class='input' type='text' value='".$checkSample[0]["bankedNucleicAcidIdentifier"]."' disabled />
				</div>
			</div>";
	echo "</div>";
	echo "<div class='row'>";
		echo "<div class='twelve columns'>";
		echo "<label class='inline' for=''>Banked Nucleic Acid (Location)</label> ";
		echo "<div class='field no-icon'>
					<input class='input' type='text' value='".$checkSample[0]["bankedNucleicAcidLocation"]."' disabled />
				</div>
			</div>";
		echo "</div>";
	echo "</div>";
	$test_results = dl::select("smp2_test_results", "sourceSampleIdentifier = '".$_POST["sample"]."'", "gene");
	echo "<div class='row'>";
	echo "<table class='table_class rounded striped'>";
		echo "<thead><tr><th>Gene</th><th>Test Method</th><th>Scope of Test</th><th>Date results released</th><th>Test Result</th><th>Test Report</th><th>Test Status</th><th>Comments</th></tr></thead>";
	foreach($test_results as $tr) {
		switch($tr["gene"]){
			case 1:
				$gene = "1 - BRAF";
				break;
			case 4:
				$gene = "4 - ALK";
				break;
			case 5:
				$gene = "5 - PIK3CA";
				break;
			case 6:
				$gene = "6 - PTEN";
				break;
			case 7:
				$gene = "7 - PTENLOH";
				break;
			case 8:
				$gene = "8 - TP53";
				break;
			case 9:
				$gene = "9 - KIT";
				break;
			case 10:
				$gene = "10 - NRAS";
				break;
			case 11:
				$gene = "11 - DDR2";
				break;
			case 12:
				$gene = "12 - TMPRSS2-ERG";
				break;
			case 13:
				$gene = "13 - EGFR";
				break;
			case 14:
				$gene = "14 - KRAS";
				break;
			case 15:
				$gene = "15 - AKT1";
				break;
			case 16:
				$gene = "16 - CCND1";
				break;
			case 17:
				$gene = "17 - CDK4";
				break;
			case 18:
				$gene = "18 - CDKN2A";
				break;
			case 19:
				$gene = "19 - CDKN2B";
				break;
			case 20:
				$gene = "20 - FGFR1";
				break;
			case 21:
				$gene = "21 - FGFR2";
				break;
			case 22:
				$gene = "22 - FGFR3";
				break;
			case 23:
				$gene = "23 - HER2";
				break;
			case 24:
				$gene = "24 - JAK2";
				break;
			case 25:
				$gene = "25 - KDR";
				break;
			case 26:
				$gene = "26 - MET";
				break;
			case 27:
				$gene = "27 - NF1";
				break;
			case 28:
				$gene = "28 - P16";
				break;
			case 29:
				$gene = "29 - PDL-1";
				break;
			case 30:
				$gene = "30 - RB1";
				break;
			case 31:
				$gene = "31 - RET";
				break;
			case 32:
				$gene = "32 - ROS1";
				break;
			case 33:
				$gene = "33 - STAT3";
				break;
			case 34:
				$gene = "34 - STK11/LKB1";
				break;
			case 35:
				$gene = "35 - TSC1";
				break;
			case 36:
				$gene = "36 - TSC2";
				break;
			case 37:
				$gene = "37 - HRAS";
				break;
			case 38:
				$gene = "38 - CCND2";
				break;
			case 39:
				$gene = "39 - CCND3 ";
				break;
			case 40:
				$gene = "40 - CCNE1";
				break;
			case 41:
				$gene = "41 - CDK2";
				break;
			case 42:
				$gene = "42 - NTRK1";
				break;
		}
		switch($tr["methodOfTest"]){
			case 1:
				$mot = "1 - FISH";
				break;
			case 2:
				$mot = "2 - MICROSAT";
				break;
			case 3:
				$mot = "3 - RQ - PCR";
				break;
			case 4:
				$mot = "4 - SEQUENCING";
				break;
			case 5:
				$mot = "5 - DIRECT SEQUENCING";
				break;
			case 6:
				$mot = "6 - PYROSEQUENCING";
				break;
			case 7:
				$mot = "7 - HRM-HIGH RESOLUTION MELT";
				break;
			case 8:
				$mot = "8 - ARMS";
				break;
			case 9:
				$mot = "9 - CE - SSCA";
				break;
			case 10:
				$mot = "10 - COBAS 4800";
				break;
			case 11:
				$mot = "11 - SNAPSHOT";
				break;
			case 12:
				$mot = "12 - RT - PCR";
				break;
			case 13:
				$mot = "13 - FRAGMENT LENGTH";
				break;
			case 14:
				$mot = "14 - Other";
				break;
			case 15:
				$mot = "15 - Illumina NGS panel 1";
				break;
			case 16:
				$mot = "16 - Illumina NGS panel 2";
				break;
		}
		switch($tr["testStatus"]){
			case 1:
				$status = "1 -  Success";
				break;
			case 2:
				$status = "2 - Partial Fail";
				break;
			case 3:
				$status = "3 - Complete Fail";
				break;
			case 4:
				$status = "4 - Pending";
				break;
		}

		echo "<tr>";
		echo "<td>";
		echo $gene;
		echo "</td>";
		echo "<td>";
		echo $mot;
		echo "</td>";
		echo "<td>";
		echo $tr["scopeOfTest"];
		echo "</td>";
		echo "<td>";
		echo $tr["dateTestResultsReleased"];
		echo "</td>";
		echo "<td>";
		echo $tr["testResult"];
		echo "</td>";
		echo "<td>";
		echo $tr["testReport"];
		echo "</td>";
		echo "<td>";
		echo $status;
		echo "</td>";
		echo "<td>";
		if(!empty($tr["comments"])){
			?>
			<span style="padding-left: 20px; cursor: pointer;"><img src="img/comments-icon.png" title="<?php echo $tr["comments"]?>" alt="<?php echo $tr["comments"]?>" /></span>
			<?php
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
}