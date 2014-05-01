<?php

// José Juan Sánchez Hernández
// @josejuansanchez

$c7 = Challenge07::singleton();
$c7->solve();

class Challenge07
{
	/**
	 * Hold an instance of the class
	 */	
 	private static $instance;

	/**
	 * Name of the phone call log
	 **/
	private $FILENAME = "phone_call.log";

	/**
	 * Id of the person A
	 **/
	private $id_a;

	/**
	 * Id of the person B
	 **/
	private $id_b;

	/**
	 * List with the ids that have been checked
	 **/
	private $checked;

	
	/**
	 * The singleton method
	 */
	public static function singleton()
	{
	    if (!isset(self::$instance)) {
	        self::$instance = new Challenge07;
	    }
	    return self::$instance;
	}

	/**
	 * Read the input from the server
	 */
	private function read_input_from_server() {
		/*
		$fin = fopen("php://stdin", "r");
		$this->id_a = trim(fgets($fin),"\n");;
		$this->id_b = trim(fgets($fin),"\n");;		
		fclose($fin);		
		*/
		$this->id_a = "54936654";
		$this->id_b = "576171409";
	}

	/**
	 * Check the phone call log
	 */
	private function check_log() {
		
		$search      = "54936654";
		//$search      = "111111111";
		
		$line_number = false;

		if ($handle = fopen("phone_call.log", "r")) {
		   $count = 0;
		   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
		      $count++;
		      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
		      echo "*** $line ***";
		   }
		   fclose($handle);
		}

		if ($line_number) {
			echo "ID: $search \n";
			echo "Line: $line_number \n";

			$file = new SplFileObject('phone_call.log');
			$file->seek($line_number-1);
			echo $file->current();
		} else {
			echo "Not connected";
		}		
	}

	/**
	 *  Returns the list of occurrences with the given id
	 */
	private function get_occurrences($id) {
		$f = fopen($this->FILENAME, "r");
		$number_of_line = 0;
		$ne = 0;
		while (($line = fgets($f, 4096)) !== FALSE) {
			if (strpos($line, $id) !== FALSE) {
				$occurrences[$ne]["id"] = trim(str_replace($id, "", $line))."\n";
				$occurrences[$ne]["nol"] = $number_of_line;
				$ne++;
			}
			$number_of_line++;
		}
		fclose($f);
		return $occurrences;		
	}

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		
		// Check if the given ids have contacts
		$contacts = $this->get_occurrences($this->id_a);
		$ne = count($contacts);

		print_r($contacts);

		if ($ne<=0) {
			echo "Not connected";
			return;
		}

		if (count($this->get_occurrences($this->id_b))<=0) {
			echo "Not connected";
			return;			
		}

		/*
		$this->checked[] = $this->id_a;
		$found = 0;

		while ((!$found) && ($ne>0)) {
			$this->checked[] = $contacts[$i];
		}
		*/
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