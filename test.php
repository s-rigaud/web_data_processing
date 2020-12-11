<?php
header('Content-type: text/xml; Encoding: utf-8');
include('Sax4php.php');

class Continent{
	private $name;
	private $area;
	private $population;
	private $countryIds;
	public $monthlyRecords;

	function __construct($name) {
		$this->name = $name;
		$this->area = 0;
		$this->population = 0;
		$this->monthlyRecords = array();
	}

	public function incrementArea($area){
		$this->area += $area;
	}

	function incrementPopulation($population){
		$this->population += $population;
	}

	function addCountryId($countryId){
		$this->countryIds[] = $countryId;
	}

	function getCountryIds(){
		return $this->countryIds;
	}

	function addMonthlyRecords(string $monthYear, int $cases, int $deaths){
		$this->monthlyRecords[$monthYear]["cases"] += $cases;
		$this->monthlyRecords[$monthYear]["deaths"] += $deaths;
	}

	function getMonthlyRecords(){
		return $this->monthlyRecords;
	}

	function getName(){
		return $this->name;
	}

	function getPopulation(){
		return $this->population;
	}

	function getArea(){
		return $this->area;
	}
}

class CovidParser extends DefaultHandler {
	// Main Idea:
	// As we are using SAX process we have to memorize and hold both continents and
	// record aggreagtions as the end display summarize both

	private $continents;
	private $lastContinent;
	private $currentKeyYearMonth;
	private $currentYear;

	function __construct() {
		parent::__construct();
		$this->continents = array();
	}

	public function startDocument() {
		echo '<?xml version="1.0" encoding="UTF-8"?>\n';
		echo '<!DOCTYPE bilan-continents SYSTEM "info.dtd">\n';
		echo '<bilan-continents>\n';
	}

	function endDocument() {
		foreach($this->continents as $continent){
			echo '<continent name="' . $continent->name . '" population="' . $continent->population . '" area="' . $continent->area . '">';
			foreach($continent->records as $keyYearMonth => $deathAndCases){
				echo '<month no="' . $keyYearMonth . '" cases="' . $deathAndCases["cases"] . '" deaths="' . $deathAndCases["deaths"] . '"/>';
			}
			echo '<continent/>';
		}
		echo '</bilan-continents>\n';
	}

	function characters($txt) {}

	function startElement($nom, $att) {
		switch ($nom) {
			case 'continent':
				$this->lastContinent = new Continent($att["name"]);
				$this->continents[] = $this->lastContinent;
				break;

			case 'country':
				print_r( isset($att["area"]));
				if (isset($att["area"])){
					$this->lastContinent->incrementArea($att["area"]);
				}
				$this->lastContinent->incrementPopulation($att["population"]);
				$this->lastContinent->addCountryId($att["xml:id"]);
				break;

			case 'year':
				$this->currentYear = $att["no"];
				break;

			case 'month':
				$this->currentKeyYearMonth = $this->currentYear.' '.$att["no"];
				break;

			case 'record':
				$concernedContinent = $this->getContinentByCountryId($att['country']);
				if (! array_key_exists($this->currentKeyYearMonth, $concernedContinent->monthlyRecords)){
					$concernedContinent->monthlyRecords[$this->currentKeyYearMonth] = array("cases" => 0, "deaths" => 0);
				}
				$concernedContinent->addMonthlyRecords($this->currentKeyYearMonth, $att["cases"], $att["deaths"]);
				break;

			default:
				//echo "$nom not handled in start element";
				break;
		}
	}

	function getContinentByCountryId($countryId){
		foreach($this->continents as $continent){
			if(in_array($countryId, $continent->getCountryIds())){
				return $continent;
			}
		}
	}

	function endElement($nom) {
		switch ($nom) {

			default:
				//echo "$nom not handled in end element";
				break;
		}
	}
}

try {
	$sax = new SaxParser( new CovidParser() );
	$sax->parse('covid-tp.xml');
} catch(SAXException $e){ echo "\n",$e;}
  catch(Exception $e) { echo "Capture de l'exception par défaut\n", $e;
}
?>