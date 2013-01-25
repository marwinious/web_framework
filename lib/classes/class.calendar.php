<?PHP
/*
CSS ELEMENTS FOR CALENDAR:
table.calendar
th.calendar-header
tr.calendar-row
th.calendar-day-head
td.calendar-day-np
td.calendar-day
div.day-number
*/

class calendar {
	private $db;
	
	// INIT
	function __construct($table='',$db_field='',$db_display_field='') {
		$this->table = $table;
		$this->db_field = $db_field;
		$this->db_display_field = $db_display_field;
		$this->db = new mysql();
	}
	
	// CREATE CALENDAR
	function draw_calendar($month,$year) {
		// BEGIN TABLE
		$calendar = "<table cellpadding='0' cellspacing='0' class='calendar'>\n";
		
		// CREATE MONTH/YEAR HEADER
		$header_month = date('F',mktime(0,0,0,$month,1,$year));
		$calendar .= "<tr>\n<th class='calendar-header' colspan='10'>{$header_month} {$year}</th>\n</tr>\n";
		
		// CREATE DAY-OF-THE-WEEK HEADINGS
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar .= "<tr class='calendar-row'>\n<th class='calendar-day-head'>".implode("</th><th class='calendar-day-head'>",$headings)."</th>\n</tr>\n";
		
		// SETUP DAYS AND WEEKS
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();
		
		// ROW FOR FIRST WEEK
		$calendar .= "<tr class='calendar-row'>\n";
		
		// ADD "BLANK" DAYS UNTIL FIRST DAY OF CURRENT WEEK
		for($i=0;$i<$running_day;$i++) {
			$calendar .= "<td class='calendar-day-np'>&nbsp;</td>\n";
			$days_in_this_week++;
		}
		
		// ADD REMAINING DAYS
		for($list_day = 1;$list_day <= $days_in_month;$list_day++) {
			$calendar .= "<td class='calendar-day'>";
			// ADD DAY NUMBER
			$calendar .= "<div class='day-number'>".$list_day."</div>";
			
			// ADD CALENDAR ITEM(S)
			if(!empty($this->table) && !empty($this->db_field) && !empty($this->db_display_field)) {
				// SETUP DATE TO MATCH DB-STYLE
				$event_month = $month;
				$event_day = $list_day;
				if(strlen($event_month) < 2) { $event_month = '0'.$event_month; }
				if(strlen($event_day) < 2) { $event_day = '0'.$event_day; }
				$event_date = "{$year}-{$event_month}-{$event_day}";
				
				// GET EVENTS FOR THIS DATE
				$events = $this->get_calendar_events($event_date);
				
				foreach($events as $event) {
					$calendar .= "<p>{$event[$this->db_display_field]}</p>";
				}
			}
			
			// ADD SPACING FOR AESTHETICS
			//$calendar .= str_repeat("<p>&nbsp;</p>",2);
			
			// CLOSE CELL
			$calendar .= "</td>\n";
			
			// CLOSE AND/OR ADD ROWS
			if($running_day == 6) {
				// CLOSE ROW
				$calendar .= "</tr>\n";
				
				if(($day_counter+1) != $days_in_month) {
					// START A NEW ROW
					$calendar .= "<tr class='calendar-row'>\n";
				}
				
				// RESET COUNTERS
				$running_day = -1;
				$days_in_this_week = 0;
			}
			
			// INCREMENT COUNTERS
			$days_in_this_week++;
			$running_day++;
			$day_counter++;
		}
		
		// FINISH REMAINING DAYS IN THE WEEK
		if($days_in_this_week < 8) {
			for($i=0;$i<(8-$days_in_this_week);$i++) {
				$calendar .= "<td class='calendar-day-np'>&nbsp;</td>\n";
			}
		}
		
		// CLOSE FINAL ROW
		$calendar .= "</tr>\n";
		
		// CLOSE TABLE
		$calendar .= "</table>\n";
		
		return $calendar;
	}
	
	// GET CALENDAR EVENT(S) BY DATE
	function get_calendar_events($date) {
		// QUERY
		$sql = "
		SELECT {$this->db_display_field}
		FROM {$this->table}
		WHERE {$this->db_field} = '{$date}'
		ORDER BY {$this->db_field} ASC
		";
		
		return $this->db->query($sql);
	}
}
?>