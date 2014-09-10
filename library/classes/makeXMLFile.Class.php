<?php

class makeXML {

    static public function makeXMLFile($id) {
        $hubName                    = dl::select("smp2_hub");
        $dom                        = new DOMDocument("1.0", "UTF-8");
        $root                       = $dom->createElement('smpSample');
        $dom->                      appendChild($root);
        $root->                     setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $dom->                      appendChild($root);
        $root->                     setAttribute("xsi:noNamespaceSchemaLocation", "schema/SMP2XSD (Request,Results) v3.4a.xsd");
        $dom->                      appendChild($root);
        foreach($hubName as $hn){
            $hub                    = $dom->createElement('smClinicalHub');
            $hub->setAttribute("name", $hn["hubName"]);
            $root->appendChild($hub);
        }
        $patient                    = $dom->createElement('patient');
        $patient                    = $hub->appendChild($patient);
        $patientInfo                = dl::select("smp2_patients", "p_id =".$id." limit 1");
        foreach($patientInfo as $pInfo) {
        $pInfo                      = array_slice($pInfo, 2);
            foreach($pInfo as $pInf=>$values) {
                if($pInf            == "cancerTreatmentModality"){
                    $modalities     = explode(",", $values);
                    $modal          = $dom->createElement('cancerTreatmentModalities');
                    $patient->appendChild($modal);
                    foreach($modalities as $modality){
                    $treatment      = $dom->createElement('cancerTreatmentModality');
                    $modal->appendChild($treatment);
                    $treatmentText  = $dom->createTextNode($modality);
                    $treatment->appendChild($treatmentText);
                }
                }else{
                    $info           = $dom->createElement($pInf);
                    $patient->appendChild($info);
                    $text           = $dom->createTextNode($values);
                    $info->appendChild($text);
                }
            }
        }
        $findSample                 = dl::select("smp2_patient_samples", "patients_id = ".$id);
        $samplesId                  = $findSample[0]["samples_id"];
        $sampleInfo                 = dl::select("smp2_samples", "s_id = ".$samplesId);
        $sample                     = $dom->createElement('sample');
        $root->appendChild($sample);
        $elements                   = $dom->createElement('clinicalHubElements');
        $sample->appendChild($elements);
        foreach($sampleInfo as $sInfo){
            $sInfo                  = array_slice($sInfo, 1);
            foreach( $sInfo as $sInf=>$values ) {
                $info               = $dom->createElement($sInf);
                $elements->appendChild($info);
                $text               = $dom->createTextNode($values);
                $info->appendChild($text);
            }
        }
        $techHubElements            = $dom->createElement('technologyHubElements');
        $sample->appendChild($techHubElements);
        $smTechHub                  = $dom->createElement('smTechnologyHub');
        $root->appendChild($smTechHub);
        $smTechHub->setAttribute('name', '2 - Cardiff');
        $dom->formatOutput          = true;
        //show the xml document
            //echo "<xmp>". $dom->saveXML(). "</xmp>";

        //set to true if you are testing the transfer.
        // this will place a prefix of "test_" at the front of the filename.
        $testing                    = true;
        if($testing) {
            $prefix = "test_";
        }else{
            $prefix = "";
        }

        //create xml document name
        $today                      = date("Y-m-d");
        $org                        = $patientInfo[0]["organisationCode"];
        $patId                      = $patientInfo[0]["localPatientIdentifier"];
        $sampId                     = $sampleInfo[0]["sourceSampleIdentifier"];

        $fileName                   = $prefix.$today."_".$org."_".$patId."_".$sampId.".xml";
        $dom->save("../../xml-documents/".$fileName);
        //now lets save the filename to the database to retrieve later
        //check to see if the filename has been recorded. The file will over write the existing so should work if there are changes added on the same date
        $findFile = dl::select("smp2_filename", "filename='".$fileName."'");
        if(empty($findFile)) {
            dl::insert("smp2_filename", array("samples_id"=>$samplesId, "filename"=>$fileName));
        }
    }
}