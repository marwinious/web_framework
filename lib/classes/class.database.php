<?PHP
// MYSQL
class mysql {
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;

	// CHOOSE DEFAULT DB UPON INSTANTIATION
	function __construct() {
		$this->use_db();
	}

	// DATABASE SELECTION
	function use_db($choice='default') {
		global $_db;

		if(isset($_db[$choice])) {
			$this->dbHost = $_db[$choice]['host'];
			$this->dbUser = $_db[$choice]['user'];
			$this->dbPass = $_db[$choice]['pass'];
			$this->dbName = $_db[$choice]['db'];
		}
	}
	
	// DATABASE QUERY FUNCTION
	function query($sql,$load_array=true) {
		// CREATE CONNECTION
		$array = array();
		
		$con = mysql_connect($this->dbHost,$this->dbUser,$this->dbPass);
		if (!$con) {
			die('Could not connect: '.mysql_error());
		}

		mysql_select_db($this->dbName, $con) or die("Could not select $dbName: " . mysql_error());

		$result = mysql_query($sql) or die("Could not query database: " . mysql_error());
		if(is_bool($result)) { $id = mysql_insert_id(); }
		mysql_close($con);
		
		if(!is_bool($result)) {
			if($load_array) {
				while($row = mysql_fetch_assoc($result)) {
					$array[] = $row;
				}

				return $array;
			}
			else {
				return $result;
			}
		}
		else {
			return $id;
		}
	}
	
	// RETURN PRIVATE VARIABLES
	function get_dbhost() { return $this->dbHost; }
	function get_dbuser() { return $this->dbUser; }
	function get_dbpass() { return $this->dbPass; }
	function get_dbname() { return $this->dbName; }
}

// SQL
class sql {
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;

	// CHOOSE DEFAULT DB UPON INSTANTIATION
	function __construct() {
		$this->use_db();
	}

	// DATABASE SELECTION
	function use_db($choice='default') {
		global $_db;

		if(isset($_db[$choice])) {
			$this->dbHost = $_db[$choice]['host'];
			$this->dbUser = $_db[$choice]['user'];
			$this->dbPass = $_db[$choice]['pass'];
			$this->dbName = $_db[$choice]['db'];
		}
	}
	
	// DATABASE QUERY FUNCTION
	function query($sql) {
		// CREATE CONNECTION
		$array = array();
		
		$con = mssql_connect($this->dbHost,$this->dbUser,$this->dbPass);
		if (!$con) {
			die('Could not connect: '.mssql_get_last_message());
		}

		mssql_select_db($this->dbName, $con) or die("Could not select $dbName: " . mssql_get_last_message());

		$result = mssql_query($sql) or die("Could not query database: " . mssql_get_last_message());
		//if(is_bool($result)) { $id = mssql_insert_id(); }
		mssql_close($con);
		
		if(!is_bool($result)) {
			while($row = mssql_fetch_array($result)) {
				$array[] = $row;
			}

			return $array;
		}
		else {
			//return $id;
			return "";
		}
	}
	
	// RETURN PRIVATE VARIABLES
	function get_dbhost() { return $this->dbHost; }
	function get_dbuser() { return $this->dbUser; }
	function get_dbpass() { return $this->dbPass; }
	function get_dbname() { return $this->dbName; }
}

// ODBC
class odbc {
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;

	// CHOOSE DEFAULT DB UPON INSTANTIATION
	function __construct() {
		$this->use_db();
	}

	// DATABASE SELECTION
	function use_db($choice='default') {
		global $_db;

		if(isset($_db[$choice])) {
			$this->dbHost = $_db[$choice]['host'];
			$this->dbUser = $_db[$choice]['user'];
			$this->dbPass = $_db[$choice]['pass'];
			$this->dbName = $_db[$choice]['db'];
		}
	}
	
	// DATABASE QUERY FUNCTION
	function query($sql) {
		// CREATE CONNECTION
		$array = array();
		
		$con = odbc_connect($this->dbHost,$this->dbUser,$this->dbPass);
		if (!$con) {
			die('Could not connect: '.odbc_error());
		}

		$result = odbc_exec($sql) or die("Could not query database: " . odbc_error());
		//if(is_bool($result)) { $id = mssql_insert_id(); }
		odbc_close($con);
		
		if(!is_bool($result)) {
			while($row = odbc_fetch_array($result)) {
				$array[] = $row;
			}

			return $array;
		}
		else {
			//return $id;
			return "";
		}
	}
	
	// RETURN PRIVATE VARIABLES
	function get_dbhost() { return $this->dbHost; }
	function get_dbuser() { return $this->dbUser; }
	function get_dbpass() { return $this->dbPass; }
	function get_dbname() { return $this->dbName; }
}

// SYBASE
class sybase {
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;
	
	// CHOOSE DEFAULT DB UPON INSTANTIATION
	function __construct() {
		$this->use_db();
	}

	// DATABASE SELECTION
	function use_db($choice='default') {
		global $_db;

		if(isset($_db[$choice])) {
			$this->dbHost = $_db[$choice]['host'];
			$this->dbUser = $_db[$choice]['user'];
			$this->dbPass = $_db[$choice]['pass'];
			$this->dbName = $_db[$choice]['db'];
		}
	}
	
	function query($sql) {
		$array = array();
	
		$sybase_conn = @sybase_connect($this->dbHost,$this->dbUser,$this->dbPass) or die("Could not connect to sybase: ".sybase_get_last_message()."<br />".$this->interface.", ".$this->dbName);
		
		if(!empty($this->dbName)) { sybase_select_db($this->dbName) or die("Could not select db: ".$this->dbName); }
		
		if(!$result = sybase_query($sql,$sybase_conn)) {
			die("Error: could not query database. <br />Message: ".sybase_get_last_message()."<br />Query: $sql");
		}
		
		while($row = sybase_fetch_assoc($result)) {
			$array[] = $row;
		}
		
		sybase_close($sybase_conn);
		
		return $array;
	}
}
?>