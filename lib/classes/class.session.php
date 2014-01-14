<?PHP
class session {
	
	function login($form) {
		$db = new mysql();
	
		// CLEAN
		$clean = clean::input($form);
		$mysql = clean::mysql($clean);
		
		if(isset($mysql['password'])) { $mysql['password'] = md5($mysql['password']); }
	
		$sql = "
		SELECT *
		FROM users u, groups g, roles r
		WHERE email = '{$mysql['email']}'
		AND u.groupid = g.id
		AND u.roleid = r.id
		LIMIT 1
		";
		
		$result = $db->query($sql);
		
		if(!empty($result)) {
			if(($result[0]['password'] === $mysql['password'])) {
				$this->id = $result[0]['id'];
				$this->first_name = $result[0]['first_name'];
				$this->last_name = $result[0]['last_name'];
				$this->email = $result[0]['email'];
				$this->phone = $result[0]['phone'];
				$this->group = $result[0]['group'];
				$this->role = $result[0]['role'];
			}
			else {
				return false;
			}
			
			return true;
		}
		else {
			return false;
		}
	}
	
	function is_logged() {
		if(isset($this->id) && !empty($this->id)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function get_name() { return $this->first_name." ".$this->last_name; }
	function get_variable($var) { return $this->$var; }
	
	function logout() {
		session_destroy();
	}
	
	function grant($type='basic') {
		if($type == 'basic') {
			return true;
		}
		elseif($type == 'admin' && $this->type == 'admin') {
			return true;
		}
		else {
			return false;
		}
	}
	
	function redirect($redirect='') {
		if(!empty($redirect)) {
			header("Location: $redirect");
			exit;
		}
		else {
			header("Location: index.php");
			exit;
		}
	}
}
?>