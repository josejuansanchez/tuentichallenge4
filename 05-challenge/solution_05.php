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

		// Initialize the next generation
		$next_generation = $this->initialize_next_generation();

		for($i=0; $i<$this->GRID_SIZE; $i++) {			
			for($j=0; $j<$this->GRID_SIZE; $j++) {

				$cont = 0;

				// Count the neighbors
				if (($i-1>=0) && ($j-1>=0) && ($this->grid[$i-1][$j-1] == 'X')) $cont++;
				if (($i-1>=0) && ($this->grid[$i-1][$j] == 'X')) $cont++;
				if (($i-1>=0) && ($j+1<$this->GRID_SIZE) && ($this->grid[$i-1][$j+1] == 'X')) $cont++;
				if (($j-1>=0) && ($this->grid[$i][$j-1] == 'X')) $cont++;
				if (($j+1<$this->GRID_SIZE) && ($this->grid[$i][$j+1] == 'X')) $cont++;
				if (($i+1<$this->GRID_SIZE) && ($j-1>=0) && ($this->grid[$i+1][$j-1] == 'X')) $cont++;
				if (($i+1<$this->GRID_SIZE) && ($this->grid[$i+1][$j] == 'X')) $cont++;
				if (($i+1<$this->GRID_SIZE) && ($j+1<$this->GRID_SIZE) && ($this->grid[$i+1][$j+1] == 'X')) $cont++;

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
			}
		}

		return $next_generation;
	}

	/**
	 *  Print a grid
	 */
	private function print_grid($g) {
		for($i=0; $i<$this->GRID_SIZE; $i++) {
			for($j=0; $j<$this->GRID_SIZE; $j++) {
				echo $g[$i][$j];
			}
			echo "\n";
		}
		echo "\n";
	}

	/**
	 *  Initialize the next generation
	 */
	private function initialize_next_generation() {
		for($i=0; $i<$this->GRID_SIZE; $i++) {
			for($j=0; $j<$this->GRID_SIZE; $j++) {
				$ng[$i][$j] = '-';
			}
		}
		return $ng;
	}

	/**
	 *  Compare two grids
	 */
	private function compare_grids($ga, $gb) {
		$are_the_same = 1;
		for($i=0; ($i<$this->GRID_SIZE) && ($are_the_same == 1); $i++) {
			for($j=0; ($j<$this->GRID_SIZE) && ($are_the_same == 1); $j++) {
				if ($ga[$i][$j] != $gb[$i][$j]) {
					$are_the_same = 0;
				}				
			}
		}
		return $are_the_same;
	}	

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {

		$got_solution = 0;
		for($k=0; ($k < 100) && (!$got_solution); $k++) {
			// Calculate the next generation and update the history
			$next_generation = $this->calculate_next_generation();
			//$this->print_grid($next_generation);
			$this->history[] = $next_generation;

			// Update the current grid
			$this->grid = $next_generation;

			// Compare the grids to find if there are two grids with the same values
			$ne = count($this->history);
			for($i=$ne-2; $i>=0; $i--) {
				if ($this->compare_grids($this->history[$ne-1],$this->history[$i])) {
					$generation = $i;
					$period = ($ne-1-$i);
					$got_solution = 1;
					echo "$generation $period";
					break;
				}
			}
		}

	}

	/**
	 * Solve the challenge
	 */
	public function solve() {
		$this->read_input_from_server();
		$this->history[] = $this->grid;
		$this->print_output();
	}
}

?>