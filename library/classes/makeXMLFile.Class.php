<?php

class makeXML {
	public $schema;

	public function add_Schema($schemaDescription){
		$this->schema = $schemaDescription;
	}

	public function set_Schema(){
		return "schema/SMP2XSD (Request,Results) v3.4a.xsd";
	}

    public function makeXMLFile($patient_id, $sample_id) {
        $hubName                    = dl::select("smp2_hub");
        $dom                        = new DOMDocument("1.0", "UTF-8");
        $root                       = $dom->createElement('smpSample');
        $dom->                      appendChild($root);
        $root->                     setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $dom->                      appendChild($root);
		$this->add_Schema(			$this->set_Schema());
        $root->                     setAttribute("xsi:noNamespaceSchemaLocation", $this->schema);
        $dom->                      appendChild($root);
        foreach($hubName as $hn){
            $hub                    = $dom->createElement('smClinicalHub');
            $hub->setAttribute("name", $hn["hubName"]);
            $root->appendChild($hub);
        }
        $patient                    = $dom->createElement('patient');
        $patient                    = $hub->appendChild($patient);
        $patientInfo                = dl::select("smp2_patients", "p_id =".$patient_id." limit 1");
        foreach($patientInfo as $pInfo) {
        $pInfo                      = array_slice($pInfo, 2);
            foreach($pInfo as $pInf=>$values) {
                if($pInf            == "cancerTreatmentModality"){
					if(!empty($values) or is_numeric($values)) {
						$modalities     = explode(",", $values);
						$modal          = $dom->createElement('cancerTreatmentModalities');
						$patient->appendChild($modal);
						foreach($modalities as $modality){
							$treatment      = $dom->createElement('cancerTreatmentModality');
							$modal->appendChild($treatment);
							$treatmentText  = $dom->createTextNode($modality);
							$treatment->appendChild($treatmentText);
						}
					}
                }else{
					if(!empty($values) or is_numeric($values)){
						$info           = $dom->createElement($pInf);
						$patient->appendChild($info);
						$text           = $dom->createTextNode($values);
						$info->appendChild($text);
					}
                }
            }
        }
        $samplesId                  = $sample_id;
        $sampleInfo                 = dl::select("smp2_samples", "s_id = ".$samplesId);
		$sampleIdentifier			= $sampleInfo[0]["sourceSampleIdentifier"];
        $sample                     = $dom->createElement('sample');
        $root->appendChild($sample);
        $elements                   = $dom->createElement('clinicalHubElements');
        $sample->appendChild($elements);
        foreach($sampleInfo as $sInfo){
            $sInfo                  = array_slice($sInfo, 1);
            foreach( $sInfo as $sInf=>$values ) {
             if($sInf               == "morphologySnomed"){
				if(!empty($values) or is_numeric($values)){
					$snoMed             = $dom->createElement('morphologySnomed');
					$elements->appendChild($snoMed);
					$cdataSection       = $dom->createCDATASection($values);
					$snoMed->appendChild($cdataSection);
				}
             }else{
				if(!empty($values) or is_numeric($values)){
					$info               = $dom->createElement($sInf);
					$elements->appendChild($info);
					$text               = $dom->createTextNode($values);
					$info->appendChild($text);
				}
             }
            }
        }
		$this->addTechHubElements($sampleIdentifier, $dom, $sample);
		$smTechHub                  = $dom->createElement('smTechnologyHub');
		$root->appendChild($smTechHub);
		$smTechHub->setAttribute('name', '2 - Cardiff');
		$this->addResultsIfRequired($sampleIdentifier, $dom, $smTechHub, $root);
        $dom->formatOutput          = true;

        //set to true if you are testing the transfer.
        // this will place a prefix of "test_" at the front of the filename.
        $testing                    = false;
        if($testing) {
            $prefix = "test_";
        }else{
            $prefix = "";
        }

        //create xml document name
        $today                      = date("Ymd");
        $org                        = $patientInfo[0]["organisationCode"];
        $patId                      = $patientInfo[0]["localPatientIdentifier"];
        $sampId                     = $sampleInfo[0]["sourceSampleIdentifier"];

        $fileName                   = $prefix.$today." ".$org."-".$patId."-".$sampId.".xml";
		$fileLocation = $this->setFilelocation($fileName);
		$dom->save($fileLocation.$fileName);
        //now lets save the filename to the database to retrieve later
        //check to see if the filename has been recorded. The file will over write the existing so should work if there are changes added on the same date
        $findFile = dl::select("smp2_filename", "samples_id=".$samplesId);
        if(empty($findFile)) {
            dl::insert("smp2_filename", array("samples_id"=>$samplesId, "filename"=>$fileName));
        }else{
			dl::update("smp2_filename", array("filename"=>$fileName), "samples_id =".$samplesId);
		}
    }

	public function addTechHubElements($sampleId, $dom, $sample){
		$techHubElements            = $dom->createElement('technologyHubElements');
		$sample->appendChild($techHubElements);
	}
	public function addResultsIfRequired($sampleID, $dom, $sample, $root) {
		return false;
	}

	public function setFileLocation(){
		if(!defined("ROOT_FOLDER")){
			$root = $_SERVER["DOCUMENT_ROOT"];
			define('ROOT_FOLDER', $root);
		}
		return(ROOT_FOLDER."SMP2/xml-documents/");
	}
}