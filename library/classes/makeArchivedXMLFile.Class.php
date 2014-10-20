<?php
class makeArchiveXML extends makeXML {

	public function set_Schema(){
		return "../schema/SMP2XSD (CH-Archive) v3.4.xsd";
	}

	public function addTechHubElements($sampleId, $dom, $sample){
		$sample_results = dl::select("smp2_sample_results", "sourceSampleidentifier = '".$sampleId."'");
		$techHubElements            = $dom->createElement('technologyHubElements');
		$sample->appendChild($techHubElements);
		$sample_results = array_slice($sample_results, 2);
		foreach($sample_results as $results=>$values) {
			if($results == "volumeBankedNucleicAcid"){
				if(!empty($values)){
					$volBank            = $dom->createElement($results);
					$techHubElements->appendChild($volBank);
					$cdataSection       = $dom->createCDATASection($values);
					$volBank->appendChild($cdataSection);
				}
			}else{
				if(!empty($values)){
					$info               = $dom->createElement($results);
					$techHubElements->appendChild($info);
					$text               = $dom->createTextNode($values);
					$info->appendChild($text);
				}
			}
		}

	}

	public function addResultsIfRequired($sampleID, $dom, $smTechHub, $root) {
		$testResults					= $dom->createElement("testResults");
		$smTechHub->appendChild($testResults);
		//get the information from the sample results table
		$test_results 					= dl::select("smp2_test_results", "sourceSampleIdentifier = '".$sampleID."' order by gene");
		if(!empty($test_results)){
			foreach($test_results as $tests){
				$testTag				= $dom->createElement("test");
				$testResults->appendChild($testTag);
				//gene result
				$gene					= $dom->createElement("gene");
				$testTag->appendChild($gene);
				$geneTxt				= $dom->createTextNode($tests["gene"]);
				$gene->appendChild($geneTxt);
				//methodOfTest result
				$mot					= $dom->createElement("methodOfTest");
				$testTag->appendChild($mot);
				$motTxt					= $dom->createTextNode($tests["methodOfTest"]);
				$mot->appendChild($motTxt);
				//scopeOfTest result
				$sot					= $dom->createElement("scopeOfTest");
				$testTag->appendChild($sot);
				$sotTxt					= $dom->createCDATASection($tests["scopeOfTest"]);
				$sot->appendChild($sotTxt);
				//dateTestResultsReleased result
				$released				= $dom->createElement("dateTestResultsReleased");
				$testTag->appendChild($released);
				$releasedTxt			= $dom->createTextNode($tests["dateTestResultsReleased"]);
				$released->appendChild($releasedTxt);
				//testResult result
				$testResult				= $dom->createElement("testResult");
				$testTag->appendChild($testResult);
				$testResultTxt			= $dom->createCDATASection($tests["testResult"]);
				$testResult->appendChild($testResultTxt);
				//testReport result
				$testReport				= $dom->createElement("testReport");
				$testTag->appendChild($testReport);
				$testReportTxt			= $dom->createCDATASection($tests["testReport"]);
				$testReport->appendChild($testReportTxt);
				//testStatus result
				$testStatus				= $dom->createElement("testStatus");
				$testTag->appendChild($testStatus);
				$testStatusTxt			= $dom->createTextNode($tests["testStatus"]);
				$testStatus->appendChild($testStatusTxt);
				//comments result
				$testComments			= $dom->createElement("comments");
				$testTag->appendChild($testComments);
				$testCommentsTxt		= $dom->createCDATASection($tests["comments"]);
				$testComments->appendChild($testCommentsTxt);
			}
		}
	}

	public function setFileLocation(){
		return("../../xml-documents/files-archived/");
	}
}