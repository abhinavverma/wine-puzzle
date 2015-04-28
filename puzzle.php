<?php
/**
 * puzzle.php is a PHP script which is coded in patern of PHP5 and runs on PHP CLI to give a project of wine sold by vineyards of Apan.
 *
 * This script is coded in PHP 5.5.X+, this script is executed and tested on 2 Core Xeon Processor, 2GB RAM, Ubuntu 14.04x64, with LEMP environment
 * with PHP version PHP 5.5.9-1ubuntu4.9 (cli) (built: Apr 17 2015 11:44:57), this script on an average took 14-16 seconds to execute and provide
 * result with the solution below we receive maximum sale by Apan Vineyard are : 297448. it runs on PHP CLI.
 * 
 * Class Puzzle contain a function which iterate between file "person_wine_3.txt" and retun another set of file which contain desired result.
 *
 * PHP version 5.5.X
 *
 *
 * @package    Wine Yard Puzzle
 * @author     Abhinav Verma <abhinav.verma20@gmail.com>
 * @version    0.1
 * @link       https://github.com/abhinavverma/wine-puzzle
 * @since      File available since Release 0.1
 */
class Puzzle{
	/**
     * Class Puzzle
     *
     * input the file name in class to process
     *
     * @var $fileName
     */
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
echo "Script Execution started at : ".date('Y-m-d H:i:s')."\n";
$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->assignWines();
echo "Script Execution stoped at : ".date('Y-m-d H:i:s')."\n";
?>
