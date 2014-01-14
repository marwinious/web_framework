/*
/ PLUGIN NAME: FORM VALIDATOR FOR JQUERY
/ DESCRIPTION: VALIDATES INPUT FOR FORM ELEMENTS
/ AUTHOR: DARIUS BABCOCK
/ CONTRIBUTORS: GERALD FULLAM
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
				errorColor: '#FFE1E1',
				passColor: '#FFFFFF',
				appendTo: 'body',
				callBack: ''
			}
			
			options = $.extend(defaults, options);
			var o = options;
			
			// LOOP THROUGH QUALIFYING ELEMENTS FOR BLUR/FOCUS DETECTIONS
			$(this).find(':input[data-validate], select[data-validate] option:selected').each(function() {
				$(this).focus(function() {
					resetError($(this),options);
				}).change(function(){
					// GET VALIDATION TYPE(S)
					var type = $(this).attr('data-validate');
					var problems = "<ul>";
					
					// TRIM
					var input = $(this).val();
					var regex_trim = /^(\s+)$/;
					input = input.replace(regex_trim,'');
					
					// VALIDATE INPUT
					problems = validate(input,type,problems);
					problems += "</ul>";
					
					// CHECK FOR ERRORS AND ADD TO DOM
					setErrorBox($(this),problems,options);
				}).blur(function() {
					// GET VALIDATION TYPE(S)
					var type = $(this).attr('data-validate');
					var problems = "<ul>";
					
					// TRIM
					var input = $(this).val();
					var regex_trim = /^(\s+)$/;
					input = input.replace(regex_trim,'');
					
					// VALIDATE INPUT
					problems = validate(input,type,problems);
					problems += "</ul>";
					
					// CHECK FOR ERRORS AND ADD TO DOM
					setErrorBox($(this),problems,options);
				});
			});
			
			// ON SUBMIT...
			$(this).submit(function() {
				// INIT
				$(".validation_results,.validation_error_box").remove();
				var problems = '';
				
				// LOOP THROUGH QUALIFYING ELEMENTS FOR BLUR/FOCUS DETECTIONS
				$(this).find(':input[data-validate], select[data-validate] option:selected').each(function() {
					// INIT
					problems = '<ul>';
					
					// GET VALIDATION TYPE(S)
					if($(this).attr('data-validate')) {
						var type = $(this).attr('selected') ? $(this).parent().attr('data-validate') : $(this).attr('data-validate');
						
						// TRIM
						var input = $(this).val();
						var regex_trim = /^(\s+)$/;
						input = input.replace(regex_trim,'');
						
						// VALIDATE INPUT
						problems = validate(input,type,problems);
						problems += "</ul>";
						
						// CHECK FOR ERRORS AND ADD TO DOM
						setErrorBox($(this),problems,o);
					}
				});
				
				// TRIGGER CALLBACK FUNCTION OR APPROPRIATE RETURN
				if(problems == '<ul></ul>' && o.callBack !== '') { return o.callBack(); }
				else if(problems == '<ul></ul>') { return true; }
				else { 
					var scrollOffset = $(".validation_error_box").first().offset();
					$('html, body').animate({ scrollTop: scrollOffset.top-100 }, 'slow');
					return false;
				}
			});
			
			// FUNCTIONS
			function resetError(element,options) {
				if(element.is('[data-error-box]')) {
					var toRemove = element.attr('data-error-box');
					$("#"+toRemove).remove();
					element.css('background-color',options.passColor);
				} else {
					element.css('background-color',options.passColor);
				}
			}
			
			function validate(input,type,problems) {
				// INIT
				var found = true;
				var regex = '';
				
				// CHECK FOR MULTIPLE CONDITIONS
				var multi = type.split(' ');
				
				// LOOP THROUGH ALL CONDITIONS
				for(var c=0;c<multi.length;c++) {
					type = multi[c];
					
					// CHECK FOR PARAMETERS AND SPLIT IF FOUND
					
					if(type.search(/\[/i) != '-1') {
						var params = type.split('[');
						type = params[0];
						params[1] = params[1].replace(/\]/,'');
					}
					
					switch(type) {
						case "number": case "numbers":
							regex = /^\d+$/;
							found = regex.test(input);
							problems = addMissing(problems,'Required format: numbers only',found);
							break;
							
						case "date":
							regex = /^(0[1-9]|1[012])[\- \/.](0[1-9]|[12][0-9]|3[01])[\- \/.](19|20)\d\d$/;
							found = regex.test(input);
							problems = addMissing(problems,'Required format: 12/31/2001',found);
							break;
							
						case "string":
							regex = /([A-Za-z0-9\-\']+)/;
							found = regex.test(input);
							problems = addMissing(problems,'Required format: letters and numbers only',found);
							break;
							
						case "email":
							regex = /^([A-Za-z0-9\.\-_]+)@([A-Za-z0-9]+)\.([A-Za-z0-9]{3})$/;
							found = regex.test(input);
							problems = addMissing(problems,'Required format: youremail@yourhost.com',found);
							break;
							
						case "phone":
							regex = /([0-9]{3})-([0-9]{3})-([0-9]{4})/;
							found = regex.test(input);
							problems = addMissing(problems,'Required format: 937-555-1234',found);
							break;
							
						case "length":
							regex = '';
							var problem_text = '';
							
							if(typeof params != 'undefined') {
								var length = params[1];
								length = params[1].split(',');
								
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
								length = $(this).attr('maxlength');
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
							if(input === '') {
								found = false;
								problems = addMissing(problems,'Required field',found);
							}
							break;
							
						default:
							break;
					}
				}

				return problems;
			}
			
			function addMissing(currentMissing,newMissing,found) {
				if(!found) {
					currentMissing += "<li>"+newMissing+"</li>";
				}
				
				return currentMissing;
			}
			
			function setErrorBox(element,errors,options) {
				resetError(element,options);
				
				if(errors != '<ul></ul>') {
					// INIT
					var rand = Math.floor((Math.random()*100000)+3);
					var id = "validation_error_box_"+rand;
					var element_height = element.height();
					var element_width = element.width();
					var position = element.offset();
					element.attr('data-error-box',id);
					// DDN SPECIFIC INFO
					var offset = ($(".cmMainContainer").length > 0) ? parseInt($(".cmMainContainer").css('margin-top')) : parseInt($("body").css('margin-top'));
					
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
					// var boxTop = position.top + (element_height+10);
					// ABOVE = OG, BELOW = DDN-SPECIFIC OVERRIDE
					var boxTop = position.top - offset+30;
					var boxRight = position.left + 15;
					$("#"+id).css({
						'top': boxTop+"px",
						'left': boxRight+"px"
					});
					$("#"+id).fadeIn(500);
					$("#"+id).append('<div class="triangle_up"></div>');
					element.css('background-color',options.errorColor);
				}
				else {
					
				}
			}
			
			function addStylesheet() {
				if($("#validation_styles").length === 0) {
					var styles = '<style type="text/css" id="validation_styles">';
					styles += ".validation_error_box { background: #7d7d7d;background: rgba(0,0,0,0.5);font-size: 0.9em;padding: 3px 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;z-index: 10000;}";

					styles += ".validation_error_box .triangle_down {width: 0; ";
					styles += "height: 0;border-color: #7d7d7d;border-top: 10px solid rgba(0,0,0,0.5);border-left: 10px solid transparent;border-right: 10px solid transparent;position: absolute;left: 10px;bottom: -10px;z-index: 10000;}";

					styles += ".validation_error_box .triangle_up {width: 0px;";
					styles += "height: 0px;border-style: solid;border-width: 0 10px 10px 10px;border-color: transparent transparent rgba(0,0,0,0.5) transparent;line-height: 0px;_border-color: rgba(0,0,0,0.5) rgba(0,0,0,0.5) rgba(0,0,0,0.5) rgba(0,0,0,0.5);_filter: progid:DXImageTransform.Microsoft.Chroma(color='#000000');position: absolute;left: 10px;top: -10px;z-index: 10000;}";

					styles += ".validation_error_box ul {margin: 0;padding: 0;list-style: none;}";

					styles += ".validation_error_box ul li {margin: 0;color: #FFFFFF;}";
					styles += "</style>";
					
					$("head").append(styles);
				}
			} 
		}
	});
})(jQuery);