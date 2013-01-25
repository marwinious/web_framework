/*
/ PLUGIN NAME: FORM VALIDATOR FOR JQUERY
/ DESCRIPTION: VALIDATES INPUT FOR FORM ELEMENTS
/ AUTHOR: DARIUS BABCOCK
/ VERSION: 1.0
/ USAGE: $("#myForm").validateInput();
/ ADVANCED USAGE: $("#myForm").validateInput({
/		errorColor: '#FFFF00', // BG COLOR FOR FAILED TESTS
/		passColor: '#FFFFFF', // BG COLOR FOR PASSED TESTS
/		appendTo: 'body', // DOM ELEMENT TO APPEND TO
/		callBack: my_function // NAME OF CALLBACK FUNCTION IF SUCCESSFULL (NO QUOTES OR PARENS)
/ };
*/
(function($) {
	$.fn.extend({
		validateInput: function (options) {
			var defaults = {
				errorColor: '#ffe1e1',
				passColor: '#FFFFFF',
				appendTo: 'body',
				callBack: ''
			}
			
			var options = $.extend(defaults, options);
			var o = options;
			
			// ON FORM SUBMIT...
			$(this).submit(function() {
				// INIT
				$(".validation_results,.validation_error_box").remove();
				var i = 0;
				var problems = '';
				
				// LOOP THROUGH "TEXT" INPUT TYPES OF FORM
				$(this).find(':input[type=text][data-validate]').each(function() {
					// GET VALIDATION TYPE(S)
					var type = $(this).attr('data-validate');
					
					// TRIM
					var input = this.value;
					var regex_trim = /^(\s+)$/;
					input = input.replace(regex_trim,'');
					
					// VALIDATE BASED ON TYPE
					var found = true;
					problems = "<ul>";
					
					// CHECK FOR MULTIPLE CONDITIONS
					var multi = type.split(' ');
					
					// LOOP THROUGH ALL CONDITIONS
					for(c=0;c<multi.length;c++) {
						var type = multi[c];
						
						// CHECK FOR PARAMETERS AND SPLIT IF FOUND
						
						if(type.search(/\[/i) != '-1') {
							var params = type.split('[');
							type = params[0];
							params[1] = params[1].replace(/\]/,'')
						}
						
						switch(type) {
							case "number":
								var regex = /^\d+$/;
								found = regex.test(input);
								problems = addMissing(problems,'Required format: numbers only',found);
								break;
						
							case "date":
								var regex = /^(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d$/;
								found = regex.test(input);
								problems = addMissing(problems,'Required format: 12/31/2001',found);
								break;
								
							case "string":
								var regex = /([A-Za-z0-9-\']+)/;
								found = regex.test(input);
								problems = addMissing(problems,'Required format: letters and numbers only',found);
								break;
								
							case "email":
								var regex = /^([A-Za-z0-9]+)@([A-Za-z0-9]+)\.([A-Za-z0-9]{3})$/;
								found = regex.test(input);
								problems = addMissing(problems,'Required format: youremail@yourhost.com',found);
								break;
								
							case "phone":
								var regex = /([0-9]{3})-([0-9]{3})-([0-9]{4})/;
								found = regex.test(input);
								problems = addMissing(problems,'Required format: 937-555-1234',found);
								break;
								
							case "length":
								var regex = '';
								var problem_text = '';
								
								if(typeof params != 'undefined') {
									var proceed = true;
									var length = params[1];
									var length = params[1].split(',');
									
									if(length.length > 1) {
										regex = "[A-Za-z0-9-\\$\\^\\%\\(\\)\\<\\>\\[\\]\\\\\+=\\?\\.\\*@#&_ ]{"+length[0]+","+length[1]+"}";
										regex = new RegExp(regex);
										problem_text = "Required length: "+length[0]+"-"+length[1]+" characters";
									}
									else if(length.length > 0) {
										regex = "[A-Za-z0-9-\\$\\^\\%\\(\\)\\<\\>\\[\\]\\\\\+=\\?\\.\\*@#&_ ]{"+length[0]+",}";
										regex = new RegExp(regex);
										problem_text = "Required minimum length: "+length[0]+" characters";
									}
								}
								else if(typeof $(this).attr('maxlength') != 'undefined') {
									var length = $(this).attr('maxlength');
									regex = "[A-Za-z0-9-\\$\\^\\%\\(\\)\\<\\>\\[\\]\\\\\+=\\?\\.\\*@#&_ ]{0,"+length+",}";
									regex = new RegExp(regex);
									problem_text = "Required maximum length: "+length+" characters";
								}
								else {
									break;
								}
								found = regex.test(input);
								problems = addMissing(problems,problem_text,found);
								break;
							
							case "required":
								if(input == '') {
									found = false;
									problems = addMissing(problems,'Required field',found);
								}
								break;
							
							default:
								break;
						}
					}
					problems += "</ul>";
					
					// ADJUST FIELD STYLES
					setErrorBox($(this),problems,o);
					
					i++;
				});
				
				// TRIGGER CALLBACK FUNCTION
				if(problems == '<ul></ul>') { o.callBack(); }
				
				return false;
			});
			
			// FUNCTIONS
			function addMissing(currentMissing,newMissing,found) {
				if(!found) {
					currentMissing += "<li>"+newMissing+"</li>";
				}
				
				return currentMissing;
			}
			
			function setErrorBox(element,errors,options) {
				if(errors != '<ul></ul>') {
					// INIT
					var rand = Math.floor((Math.random()*100000)+3);
					var id = "validation_error_box_"+rand;
					var element_height = element.height();
					var element_width = element.width();
					var position = element.offset();
					
					// ADD STYLESHEET
					addStylesheet();
					
					// CREATE ERROR BOX
					$(options.appendTo).append("<div class='validation_error_box' id='"+id+"'></div>");
					
					// SET POSITION FOR ERROR BOX
					$("#"+id).css({
						'display': 'none',
						'position': 'absolute'
					}).html(errors);
					var boxHeight = $("#"+id).height();
					var boxTop = position.top - (element_height+(boxHeight-2));
					var boxRight = position.left + (element_width-25);
					$("#"+id).css({
						'top': boxTop+"px",
						'left': boxRight+"px"
					})
					$("#"+id).fadeIn(500);
					$("#"+id).append('<div class="triangle_down"></div>');
					element.css('background-color',options.errorColor);
				}
				else {
					element.css('background-color',options.passColor);
				}
			}
			
			function addStylesheet() {
				if($("#validation_styles").length == 0) {
					var styles = '<style type="text/css" id="validation_styles">';
					styles += ".validation_error_box { background: #7d7d7d;background: rgba(0,0,0,0.5);font-size: 0.9em;padding: 3px 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;z-index: 999;}";

					styles += ".validation_error_box .triangle_down{width: 0; ";
					styles += "height: 0;border-color: #7d7d7d;border-top: 10px solid rgba(0,0,0,0.5);border-left: 10px solid transparent;border-right: 10px solid transparent;position: absolute;left: 10px;bottom: -10px;z-index: 999;}";

					styles += ".validation_error_box ul {margin: 0;padding: 0;list-style: none;}";

					styles += ".validation_error_box ul li {margin: 0;color: #FFFFFF;}";
					styles += "</style>";
					
					$("head").append(styles);
				}
			} 
		}
	});
})(jQuery);