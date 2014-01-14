<?PHP
class standards {
	// FORMAT DATE TO DATABASE FORMATR
	static function dateToYMD($date) {
		$date = str_replace('-','/',$date);
		return date('Y-m-d', strtotime($date));
	}
	
	// FORMAT DATE TO HUMAN
	static function dateToHuman($date) {
		$date = str_replace('-','/',$date);
		return date('m/d/Y', strtotime($date));
	}
	
	// FORMAT DATE/TIME TO HUMAN
	static function dateTimeToHuman($date) {
		$date = str_replace('-','/',$date);
		return date('m/d/Y g:i a', strtotime($date));
	}
	
	// FORMAT DATE TO CUSTOM
	static function dateToCustom($format,$date) {
		$date = str_replace('-','/',$date);
		return date("$format",strtotime($date));
	}
	
	// FIX EMPTY DATES
	function fix_empty_date($date,$replace_with='') {
		if($date == '0000-00-00' || $date == '00/00/0000' || $date == '0000-00-00 00:00:00' || $date == '1969-12-31' || $date == '1969-12-31 00:00:00') {
			$date = '';
		}
		else {
			$date = standards::dateToHuman($date);
		}
		
		return $date;
	}
}
?>