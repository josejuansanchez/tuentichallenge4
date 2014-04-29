<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c3 = Challenge03::singleton();
$c3->solve();

class Challenge03
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	/**
	 * Number of cases
	 **/
	private $number_of_cases;

	/**
	 * List of cases
	 **/
	private $list_of_cases;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge03;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {		
		$fin = fopen("php://stdin", "r");
		$this->number_of_cases = intval(fgets($fin));
		for($i = 0; $i < $this->number_of_cases; $i++ ) {
			$line = fgets($fin);
			$numbers = explode(" ",$line);		
			$this->list_of_cases[$i]["x"] = intval($numbers[0]);
			$this->list_of_cases[$i]["y"] = intval($numbers[1]);
		}	
		fclose($fin);		
	}

	/**
	 * The Gambler's algorithm
	 */
	private function gambler_algorithm($x, $y) {
		return round(sqrt($x*$x + $y*$y), 2, PHP_ROUND_HALF_UP);
	}

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		for($i = 0; $i < $this->number_of_cases; $i++ ) {
			echo $this->gambler_algorithm(
							$this->list_of_cases[$i]["x"],
							$this->list_of_cases[$i]["y"]).
							"\n";
		}	

	}

	/**
	 * Solve the challenge
	 */
	public function solve() {
		$this->read_input_from_server();
		$this->print_output();
	}
}

?>