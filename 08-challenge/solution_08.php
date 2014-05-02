<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c8 = Challenge08::singleton();
$c8->solve();

class Challenge08
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge08;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {
		$fin = fopen("php://stdin", "r");
		$this->id_a = trim(fgets($fin),"\n");;
		$this->id_b = trim(fgets($fin),"\n");;		
		fclose($fin);		
	}

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		echo "7";
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