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
		$fin = fopen("php://stdin", "r");
		$this->id_a = trim(fgets($fin),"\n");;
		$this->id_b = trim(fgets($fin),"\n");;		
		fclose($fin);		
	}

	/**
	 *  Returns the list of occurrences with the given id
	 */
	private function get_occurrences($id) {
	
		$number_of_line = 0;		
		$occurrences = [];
		$ne = 0;

		$f = fopen($this->FILENAME, "r");		
		while (($line = fgets($f, 4096)) !== FALSE) {
			if (strpos($line, $id) !== FALSE) {

				$id_found = trim(str_replace($id, "", $line));

				if (!in_array($id_found, $occurrences)) {
					$occurrences[$ne]["id"] = $id_found;
					$occurrences[$ne]["nol"] = $number_of_line;
					$ne++;
				}
			}
			$number_of_line++;
		}
		fclose($f);
		return $occurrences;		
	}


	/**
	 *  Search the id b in the contact list
	 */
	private function search_id_b_in_contacts($contacts) {
		for($k=0; $k<count($contacts); $k++) {
			if ($contacts[$k]["id"] == $this->id_b) {
				echo "Connected at ".$contacts[$k]["nol"];
				return true;
			}
		}
		return false;
	}

	/**
	 *  Print the solution of the challenge
	 */
	private function print_output() {
		
		// No limits for the maximum execution time
		set_time_limit(0);

		// Check if the given ids have contacts
		$contacts = $this->get_occurrences($this->id_a);
		$ne = count($contacts);

		if ($ne<=0) {
			echo "Not connected";
			return;
		}

		if (count($this->get_occurrences($this->id_b))<=0) {
			echo "Not connected";
			return;			
		}

		// Search the id b in the contact list
		if ($this->search_id_b_in_contacts($contacts)) return;

		$this->checked[] = $this->id_a;
		$end = 0;
		$i = 0;

		while ($i<count($contacts)) {

			// If the id has been checked
			if (in_array($contacts[$i], $this->checked)) {
				$i++;
				continue;
			}
			
			// If the id has not been checked
			$this->checked[] = $contacts[$i];

			// Get the contacts associated with the id: $contacts[$i]
			$temp_contacts = $this->get_occurrences($contacts[$i]["id"]);

			// Search the id b in the contact list
			if ($this->search_id_b_in_contacts($contacts)) return;

			$aux = array_merge(array_slice($contacts, 0, $i+1, true),
    			   array_slice($temp_contacts, 0, count($temp_contacts), true),
    			   array_slice($contacts, $i+1, count($contacts), true));
			
			$contacts = $aux;
			$i++;
		}

		// Search the id b in the contact list
		if (!$this->search_id_b_in_contacts($contacts)) {
			echo "Not connected";			
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