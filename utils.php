<?php

/*
* 12 => 12
* 444444 => 444444
* 1234567 => 1.234567E7
* 1234567.8 => 1.2345678E7
*/
function toExpoFormat(string $number){
	if (strlen($number) <= 6){
		return $number;
	}
	$floatPart = "";
	$numberParts = preg_split('/\\./', $number, -1, PREG_SPLIT_NO_EMPTY);
	if (count($numberParts) > 1){
		$number = $numberParts[0];
		$floatPart = $numberParts[1];
	}
	$expo = "";
	while(strlen($number) > 1){
		$expo = substr($number, -1) . $expo;
		$number = substr($number, 0, -1);
	}
	return $number . '.' . rtrim($expo, '0') . $floatPart . 'E'. strlen($expo);
}

function reverseDOMNodeList(DOMNodeList $domNodeList){
    $reversed_array = array();
    foreach($domNodeList as $domNode){
        array_unshift($reversed_array, $domNode);
    }
    return $reversed_array;
}