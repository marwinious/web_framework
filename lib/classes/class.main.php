<?PHP
class main {
	private $db;
	
	// LOAD DB
	function __construct() {
		$this->db = new mysql();
	}
}
?>