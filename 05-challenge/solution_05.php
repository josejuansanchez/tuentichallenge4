<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c4 = Challenge05::singleton();
$c4->solve();

class Challenge05
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
	        self::$instance = new Challenge05;
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
	 *  Calculate the next generation
	 */
	private function calculate_next_generation() {

		for($i=0; $i<$this->GRID_SIZE; $i++) {
			$cont = 0;
			for($j=0; $j<$this->GRID_SIZE; $j++) {
				if (($i-1>=0) && ($i+1<$this->GRID_SIZE) &&
					($j-1>=0) && ($j+1<$this->GRID_SIZE)) {

					// Count the neighbors
					if ($this->grid[$i-1][$j-1] == 'X') $cont++;
					if ($this->grid[$i-1][$j] == 'X') $cont++;
					if ($this->grid[$i-1][$j+1] == 'X') $cont++;
					if ($this->grid[$i][$j-1] == 'X') $cont++;
					if ($this->grid[$i][$j+1] == 'X') $cont++;
					if ($this->grid[$i+1][$j-1] == 'X') $cont++;
					if ($this->grid[$i+1][$j] == 'X') $cont++;
					if ($this->grid[$i-1][$j+1] == 'X') $cont++;

					// Apply the rules of the "game of the life"
					if (($this->grid[$i][$j] == 'X') && (($cont==2) || ($cont==3))) {
						$next_generation[$i][$j] = 'X';
					}
					else if (($this->grid[$i][$j] == 'X') && ($cont>3)) {
						$next_generation[$i][$j] = '-';
					}
					else if (($this->grid[$i][$j] == '-') && ($cont==3)) {
						$next_generation[$i][$j] = 'X';
					}
					else {
						$next_generation[$i][$j] = '-';
					}
				} else {
					$next_generation[$i][$j] = '-';
				}
			}
		}

		// TEST
		for($i=0; $i<$this->GRID_SIZE; $i++) {
			for($j=0; $j<$this->GRID_SIZE; $j++) {
				echo $next_generation[$i][$j];
			}
			echo "\n";
		}
	}


	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		//print_r($this->grid);
	}

	/**
	 * Solve the challenge
	 */
	public function solve() {
		$this->read_input_from_server();
		$this->calculate_next_generation();
		$this->print_output();
	}
}

?>