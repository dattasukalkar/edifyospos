<?php

class PaymentResponse
{
    var $key_in_response;  // xml tag name
    var $value_in_response;    // xml tag value

    function PaymentResponse ($aa)
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}

function readResponse($response)
{
    //
    $data_in_response = $response.PHP_EOL;
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data_in_response, $values, $tags);
    xml_parser_free($parser);

    // loop through the structures
    foreach ($tags as $key=>$val) {
        if ($key == "Response") {
            $tuples = $val;
            // each contiguous pair of key and values
            for ($i=0; $i < count($tuples); $i+=2) {
                $offset = $tuples[$i] + 1;
                $len = $tuples[$i + 1] - $offset;
                $tdb[] = parseTuple(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}

function parseTuple($tvalues)
{
	$fieldsneeded = array("Card_Number","Card_Type", "Card_Entry","Reference_Number","EMV_ARPC","Approval_Code","Response_Code","Response_Text");
    for ($i=0; $i < count($tvalues); $i++)
    {
    	if( in_array($tvalues[$i]["tag"],$fieldsneeded))
		        $tuple[$tvalues[$i]["tag"]] = $tvalues[$i]["value"];
    }
    return $tuple;
}




?>