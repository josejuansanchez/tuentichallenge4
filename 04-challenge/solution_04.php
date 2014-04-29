<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c4 = Challenge04::singleton();
$c4->solve();

class Challenge04
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	/**
	 * Source state
	 **/
	private $source_state;

	/**
	 * Target state
	 **/
	private $target_state;

	/**
	 * Permitted safe states
	 **/
	private $states;

	/**
	 * Used states in transitions
	 **/
	private $used_states;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge04;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {		
		$fin = fopen("php://stdin", "r");
		$this->source_state = trim(fgets($fin),"\n");
		$this->target_state = trim(fgets($fin),"\n");

		while (!feof($fin)) {
			$line = trim(fgets($fin),"\n");
			if ($line != "") {
				$this->states[] = $line;
			}
		}
		fclose($fin);		
	}

	/**
	 * Initialize the list of used states
	 */
	private function initialize_used_states() {		
		$num = count($this->states);
		for($i=0; $i<$num; $i++) {
			// Mark the initial state as used
			if ($this->states[$i] == $this->source_state) {
				$this->used_states[$i] = 1;				
			} else {
				$this->used_states[$i] = 0;
			} 				
		}
	}

	/**
	 *  Compare two states.
	 *  Returns the number of symbols that match on each state
	 */
	private function compare_states($state_a, $state_b) {
		$cont = 0;
		$len = strlen($state_a);
		for($i=0; $i<$len; $i++) {
			if ($state_a[$i] == $state_b[$i]) $cont++;
		}
		return $cont;
	}

	/**
	 *  Return the possible states after a given state
	 */	
	private function find_possible_states($state_a) {

		// Length of the strings
		$len = strlen($state_a);

		$num = count($this->states);
		for($i=0; $i<$num; $i++) {
			if (($this->compare_states($state_a, $this->states[$i]) == $len - 1) &&
				 $this->used_states[$i] == 0) {
				$possible_states[] = $this->states[$i];
				$this->used_states[$i] = 1;
			}
		}
		return $possible_states;	
	}

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		$state_a = $this->source_state;
		do {
			echo $state_a."->";
			$possible_states = $this->find_possible_states($state_a, $this->states);
			$state_a = $possible_states[0];
		} while($state_a != $this->target_state);
		echo $this->target_state;
	}

	/**
	 * Solve the challenge
	 */
	public function solve() {
		$this->read_input_from_server();
		$this->initialize_used_states();
		$this->print_output();
	}
}

?>