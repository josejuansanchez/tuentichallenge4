<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c6 = Challenge06::singleton();
$c6->solve();

class Challenge06
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	/**
	 * Grid size (width and height)
	 **/
	private $GRID_SIZE = 8;

	/**
	 * Grid
	 **/
	private $grid;

	/**
	 * History of the states of the grid
	 **/
	private $history;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge06;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {			
		$fin = fopen("php://stdin", "r");
		while (!feof($fin)) {
			$line = trim(fgets($fin),"\n");
			if ($line != "") {
				$this->grid[] = $line;
			}
		}
		fclose($fin);		
	}


	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		echo "test";
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