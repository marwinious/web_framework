//////////////////////////////////////////////////////////////////////////////////////////////////
// AUTO-COMPLETE SCRIPT
// AUTHOR: DARIUS BABCOCK
// DEPENDENCIES: JQUERY
// DESCRIPTION:
//			Create one or more arrays of possible values and name them
//			something meaningful (eg. months, names, states, etc).
//			These arrays should be in this file. On your html page,
//			create a text field and give it a class of "auto_complete".
//			Add the attributes "results" and "against" to the field.
//			"results" should hold the id of the element that you want
//			to hold the results. The "against" attribute should hold
//			the name of the array in this file that you want to test
//			the user's input against.
//
// EXAMPLE:
//			/* HTML */
//			<input type="text" name="month" id="month" results="month_results" against="months" />
//			<div id="month_results" class="auto_complete_results" style="display: none;"></div>
//
//			/* SEE MATCHING EXAMPLE JAVASCRIPT BELOW */
//
//////////////////////////////////////////////////////////////////////////////////////////////////

var months = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

$(".auto_complete").bind("keyup", function() {
	// IF TEXT FIELD EMPTY, DO NOTHING
	if($(this).val() != "") {
		// GET INITIAL VALUES
		var input_val = $(this).val();
		var input_len = $(this).val().length;
		var results_box = $(this).attr("results");
		var source = $(this).attr("id");
		var against = $(this).attr("against");
		against = eval(against);
		
		// INITIALIZE ARRAY OF MATCHES
		var possible = new Array();
		
		// LOOP THROUGH EACH MONTH AND CHECK IF MATCHES PARTIAL INPUT VAL
		for(i=0;i<against.length;i++) {
			var check = against[i];
			check = check.substring(0,input_len);
			// IF MATCHES, ADD TO ARRAY OF POSSIBILITIES
			var match = "<a href='#' onclick=\"fill('" + source + "','" + against[i] + "','" + results_box + "');return false;\"><span class='auto_complete_match'>" + check + "</span>";
			match += against[i].substring(input_len,against[i].length) + "</a>";
			if(input_val.toUpperCase() == check.toUpperCase()) { possible.push(match); }
		}
		
		// RESET RESULTS FIELD
		$("#"+results_box).html("");
		
		// LOOP THROUGH EACH POSSIBILITY AND ADD IT TO THE RESULTS SECTION
		var results = "<ul>";
		for(i=0;i<possible.length;i++) {
			results += "<li>" + possible[i] + "</li>";
		}
		results += "</ul>";
		$("#"+results_box).append(results);
		
		// DISPLAY RESULTS
		$("#"+results_box).show();
	}
	else {
		// RESET RESULTS FIELD
		$("#"+results_box).html("").hide();
	}
});

function fill(source,filler,results_box) {
	$("#"+source).val(filler);
	$("#"+results_box).html("").hide();
}