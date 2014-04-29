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
		/*
		$fin = fopen("php://stdin", "r");
		$this->track = fgets($fin);
		fclose($fin);	
		*/
		
		//$this->track = "#----\-----/-----\-----/";
		$this->track = "------\-/-/-\-----#-------\--/----------------\--\----\---/---";
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
		for($i=0; $i<$this->max_dimension*2; $i++) {
			for($j=0; $j<$this->max_dimension*2; $j++) {
				$t[$i][$j] = ' ';
			}
		}
		$i = $this->max_dimension;
		$j = $this->max_dimension;

		$current_orientation = 'H';

		$len = strlen($this->track);
		for($k=0; $k<$len; $k++) {
			switch ($this->track[$k]) {
				case '-':
					if ($current_orientation == 'V') {
						$t[$i][$j] = "|";

						$next_orientation = 'V';

						if ($last == "T") $i--;
						if ($last == "D") $i++;
					} else {

						$t[$i][$j] = "-";

						$next_orientation = 'H';

						if ($last == "R") $j++;
						if ($last == "L") $j--;
					}
					break;

				case '\\':

					$t[$i][$j] = "\\";

					if ($current_orientation == 'H') {		
						$next_orientation = 'V';
						
						if ($last == "R") { $i++; $last = "D"; }
						if ($last == "L") { $i--; $last = "T"; }
					} else {
						$next_orientation = 'H';
						
						if ($last == "T") { $j--; $last = "L"; }
						if ($last == "D") { $j++; $last = "R"; }
					}
					break;

				case '/':

					$t[$i][$j] = "/";

					if ($current_orientation == 'H') {		
						$next_orientation = 'V';
						
						if ($last == "R") { $i--; $last = "T"; }
						if ($last == "L") { $i++; $last = "D"; }

					} else {
						$next_orientation = 'H';
						
						if ($last == "T") { $j++; $last = "R"; }
						if ($last == "D") { $j--; $last = "L"; }
					}		
					break;		

				case '#':					
					$t[$i][$j] = "#";
					$next_orientation = 'H';
					$last = "R";
					$j++;
					break;
			}

			$current_orientation = $next_orientation;
		}

		// TEST
		for($i=0; $i<$this->max_dimension*2; $i++) {
			$line ="";
			for($j=0; $j<$this->max_dimension*2; $j++) {
				//echo $t[$i][$j];
				$line .= $t[$i][$j];
			}
			if (strlen(trim($line)) > 0) echo $line."\n";
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