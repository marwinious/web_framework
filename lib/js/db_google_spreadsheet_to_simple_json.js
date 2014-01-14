/*
SCRIPT: Convert full Google Spreadsheet JSON to simple key => value object
AUTHOR: Darius Babcock
LAST UPDATED: 1/3/2014
SAMPLE USAGE:
$(document).ready(function() {
	// SPECIFY GOOGLE SPREADHSEET URL (MUST BE PUBLISHED TO WEB)
	var gsURL = 'https://spreadsheets.google.com/feeds/list/0AvZ8jb1VrdtNdGxoRE0tdEZ1U29zLU5pLUo3VVlSYnc/od6/public/values?alt=json';
	// GET SPREADSHEET CONTENTS
	$.ajax({
		url: gsURL,
		dataType: "json",
		success: function(result) {
			// CALL FUNCTION AND SAVE NEW OBJECT AS A VARIABLE
			var gsJSON = gsToSimpleJSON(result);
		}
	});
	
});
*/
// PARSE GOOGLE SPREADSHEET TO JSON
function gsToSimpleJSON(gs) {
	// INIT
	var json = {};
	json.data = [];
	
	// LOOP THROUGH ENTRIES
	for(var i=0;i<gs.feed.entry.length;i++) {
		// PUSH NEW OBJECT INTO DATA ARRAY
		json.data[i] = {};
		
		for(var colName in gs.feed.entry[i]) {
			// IF ENTRY STARTS WITH "GSX$", IT IS A COLUMN FROM THE SPREADSHEET
			if(colName.substring(0,4) == 'gsx$') {
				// ADD COLUMN NAME AND ROW CONTENT FOR COLUMN TO OBJECT
				json.data[i][colName.substring(4,colName.length)] = gs.feed.entry[i][colName]['$t'];
			}
		}
		
	}
	
	return json;
}