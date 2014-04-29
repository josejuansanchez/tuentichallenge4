<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c2 = Challenge02::singleton();
$c2->solve();

class Challenge02
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	/**
	 * A plain text line that represents the track
	 **/
	private $track;

	/**
	 * The max dimension (width or height) of the track
	 **/
	private $max_dimension;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge02;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {		
		$fin = fopen("php://stdin", "r");
		$this->track = fgets($fin);
		fclose($fin);	
	}

	/**
	 * Sort the track putting the symbol # as the first element
	 */
	private function sort_the_track() {
		$temp = split("#",$this->track);
		$this->track = "#".$temp[1].$temp[0];
	}

	/**
	 * Get the max (width or height) of the track
	 */
	private function get_max_dimension() {
		$count = 0;
		$this->max_dimension = -1;
		$len = strlen($this->track);
		for($i=0; $i<$len; $i++) {
			switch($this->track[$i]) {
				case '-':
				case '#':
					$count++;
					if ($count > $this->max_dimension) $this->max_dimension = $count;
					break;

				default:
					$count = 0;
					break;
			}
		}
	}

	/**
	 * Print the track
	 */
	private function print_track() {

		// TEST
		// Initialize a matrix with blank spaces
		for($i=0; $i<$this->max_dimension*4; $i++) {
			for($j=0; $j<$this->max_dimension*4; $j++) {
				$t[$i][$j] = ' ';
			}
		}
		
		// Set the initial coordinates
		$i = $this->max_dimension*2;
		$j = $this->max_dimension*2;

		// Set the matrix with the symbols of the track
		$current_orientation = 'H';

		// Orientation: H (Horizontal), V (Vertical)
		// Movement: T (Top), D (Down), R (Right), L (Left)

		$len = strlen($this->track);
		for($k=0; $k<$len; $k++) {
			switch ($this->track[$k]) {
				case '-':
					if ($current_orientation == 'V') {
						$t[$i][$j] = "|";

						$next_orientation = 'V';

						if ($last_movement == "T") $i--;
						if ($last_movement == "D") $i++;
					} else {

						$t[$i][$j] = "-";

						$next_orientation = 'H';

						if ($last_movement == "R") $j++;
						if ($last_movement == "L") $j--;
					}
					break;

				case '\\':
					$t[$i][$j] = "\\";

					if ($current_orientation == 'H') {		
						$next_orientation = 'V';
						
						if ($last_movement == "R") { $i++; $last_movement = "D"; }
						if ($last_movement == "L") { $i--; $last_movement = "T"; }
					} else {
						$next_orientation = 'H';
						
						if ($last_movement == "T") { $j--; $last_movement = "L"; }
						if ($last_movement == "D") { $j++; $last_movement = "R"; }
					}
					break;

				case '/':
					$t[$i][$j] = "/";

					if ($current_orientation == 'H') {		
						$next_orientation = 'V';
						
						if ($last_movement == "R") { $i--; $last_movement = "T"; }
						if ($last_movement == "L") { $i++; $last_movement = "D"; }

					} else {
						$next_orientation = 'H';
						
						if ($last_movement == "T") { $j++; $last_movement = "R"; }
						if ($last_movement == "D") { $j--; $last_movement = "L"; }
					}		
					break;		

				case '#':					
					$t[$i][$j] = "#";
					$next_orientation = 'H';
					$last_movement = "R";
					$j++;
					break;
			}
			$current_orientation = $next_orientation;
		}

		// Find the column index where appears the first symbol
		$col_index = -1;
		for($j=0; ($j<$this->max_dimension*4) && ($col_index==-1); $j++) {
			for($i=0; ($i<$this->max_dimension*4) && ($col_index==-1); $i++) {
				if ($t[$i][$j]!=' ') { 
					$col_index = $j;
				}
			}
		}

		// Print the matrix with the format expected by Tuenti
		for($i=0; $i<$this->max_dimension*4; $i++) {
			$line ="";
			for($j=$col_index; $j<$this->max_dimension*4; $j++) {
				$line .= $t[$i][$j];
			}
			if (strlen(trim($line)) > 0) echo rtrim($line)."\n";
		}

	}

	/**
	 * Solve the challenge
	 */
	public function solve() {
		$this->read_input_from_server();
		$this->sort_the_track();
		$this->get_max_dimension();
		$this->print_track();
	}
}

?>