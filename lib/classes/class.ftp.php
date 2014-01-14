<?PHP
class ftp {
	private $server;
	private $username;
	private $password;
	public $con;
	private $dir;
	
	function __construct($server,$username,$password) {
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
	}
	
	function connect() {
		$this->con = ftp_connect($this->server) or die("Could not connect to ".$this->server);
		ftp_login($this->con,$this->username,$this->password);
	}
	
	function close() {
		ftp_close($this->con);
	}
	
	function chdir($dir) {
		ftp_chdir($this->con,$dir);
		$this->dir = ftp_pwd($this->con);
	}
	
	function dir_up() {
		ftp_cdup($this->con);
		$this->dir = ftp_pwd($this->con);
	}
	
	function upload($source,$target) {
		return ftp_put($this->con,$target,$source,FTP_ASCII);
	}
	
	function cur_dir() {
		return $this->dir;
	}
	
	function list_files() {
		return ftp_nlist($this->con,$this->dir);
	}
	
	function download($target,$source) {
		if(ftp_get($this->con,$target,$source,FTP_ASCII)) { return true; }
		else { return false; }
	}
}
?>