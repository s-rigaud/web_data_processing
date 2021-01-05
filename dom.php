<?php

require 'utils.php';

header('Content-type: text/xml; Encoding: utf-8');

/* Basic native PHP dom document loading */
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->validateOnParse = true;
$doc->load("covid-tp.xml");

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<!DOCTYPE bilan-continents'."\n".'  SYSTEM "info.dtd">'."\n".'<bilan-continents>'."\n";

$dom_continents = $doc->childNodes->item(1)->firstChild->childNodes;
$dom_years = $doc->childNodes->item(1)->childNodes->item(1)->childNodes;

foreach($dom_continents as $continent){
    $continent_name = $continent->getAttribute("name");
    $continent_population = 0;
    $continent_area = 0;
    $country_ids = array();

    /* Compute total population and area of continent by summing values of the related countries */
    foreach($continent->childNodes as $dom_country){
        array_push($country_ids, $dom_country->getAttribute("xml:id"));
        $continent_population += $dom_country->getAttribute("population");
        if ($dom_country->hasAttribute("area")){
            $continent_area += $dom_country->getAttribute("area");
        }
    }
    echo '  <continent name="'. $continent_name . '" population="' . toExpoFormat($continent_population) .'" area="' . toExpoFormat($continent_area) . '">'."\n";

    $month_cases = 0;     // Init
    $month_deaths = 0;    // Init
    $has_records = false; // Init
    foreach(reverseDOMNodeList($dom_years) as $year){
        foreach(reverseDOMNodeList($year->childNodes) as $month){
            $year_month = $month->parentNode->getAttribute("no")."-".$month->getAttribute("no");
            $month_cases = 0;     // Reset
            $month_deaths = 0;    // Reset
            $has_records = false; // Reset

            foreach($month->childNodes as $day){
                foreach($day->childNodes as $record){
                    /* If record is about one country of the current continent */
                    if (in_array($record->getAttribute("country"), $country_ids)){
                        $month_cases += $record->getAttribute("cases");
                        $month_deaths += $record->getAttribute("deaths");
                        $has_records = true;
                    }
                }
            }
            if($has_records){
                echo '      <month no="' . $year_month . '" cases="' . toExpoFormat($month_cases) . '" deaths="' . toExpoFormat($month_deaths) . '"/>'."\n";
            }
        }
    }

    echo "  </continent>\n";
}
echo "</bilan-continents>\n";

