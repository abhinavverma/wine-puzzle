<?php
class Puzzle{

	public $fileName;

	function __construct($text){
		$this->fileName = $text;
	}

	public function assignWines(){
		$wineWishlist	= [];
		$wineList 		= [];
		$wineSold 		= 0;
		$finalList 		= [];
		$file 			= fopen($this->fileName,"r");
		while (($line = fgets($file)) !== false) {
			$name_and_wine = explode("\t", $line);
			$name = trim($name_and_wine[0]);
			$wine = trim($name_and_wine[1]);
			if(!array_key_exists($wine, $wineWishlist)){
				$wineWishlist[$wine] = [];
			}
			$wineWishlist[$wine][] = $name;
			$wineList[] = $wine;
		}
		fclose($file);
		$wineList = array_unique($wineList);
		foreach ($wineList as $key => $wine) {
			$maxSize = count($wine);
			$counter = 0;

			while($counter<10){
				$i = intval(floatval(rand()/(float)getrandmax()) * $maxSize);
				$person = $wineWishlist[$wine][$i];
				if(!array_key_exists($person, $finalList)){
					$finalList[$person] = [];
				}
				if(count($finalList[$person])<3){
					$finalList[$person][] = $wine;
					$wineSold++;
					break;
				}
				$counter++;
			}
		}

		$fh = fopen("finalAssign.txt", "w");
		fwrite($fh, "Total number of wine bottles sold in aggregate : ".$wineSold."\n");
		foreach (array_keys($finalList) as $key => $person) {
			foreach ($finalList[$person] as $key => $wine) {
				fwrite($fh, $person." ".$wine."\n");
			}
		}
		fclose($fh);
	}
}

$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->assignWines();

?>
