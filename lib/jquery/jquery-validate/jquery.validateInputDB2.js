/*
/ PLUGIN NAME: FORM VALIDATOR FOR JQUERY
/ DESCRIPTION: VALIDATES INPUT FOR FORM ELEMENTS
/ AUTHOR: DARIUS BABCOCK
/ CONTRIBUTORS: GERALD FULLAM
/ VERSION: 1.0
/ USAGE: $("#myForm").validateInput();
/ ADVANCED USAGE: $("#myForm").validateInput({
/		errorColor: '#FFE1E1', // COLOR FOR ERRORS
/		passColor: '#FFFFFF', // COLOR FOR VALID INPUT
/		appendTo: 'body', // ELEMENT TO APPEND ERROR BOXES TO
/		callBack: '' // FUNCTION TO CALL ON SUBMIT IF EVERYTHING VALIDATES
/ };
*/
(function($) {
	$.fn.extend({
		// NAME PLUGIN AND GET PASSED OPTIONS
		validateInput: function (options) {
			// DECLARE DEFAULT OPTIONS
			var defaults = {
				errorColor: '#FFE1E1', // COLOR FOR ERRORS
				passColor: '#FFFFFF', // COLOR FOR VALID INPUT
				appendTo: 'body', // ELEMENT TO APPEND ERROR BOXES TO
				callBack: '' // FUNCTION TO CALL ON SUBMIT IF EVERYTHING VALIDATES
			}
			
			// INIT OPTIONS FOR USE IN PLUGIN
			options = $.extend(defaults, options);
			var o = options;
			
			
		}
	});
})(jQuery);