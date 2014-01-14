/*
PLUGIN NAME: FORM VALIDATOR FOR JQUERY
DESCRIPTION: VALIDATES INPUT FOR FORM ELEMENTS
AUTHOR: DARIUS BABCOCK
CONTRIBUTORS: GERALD FULLAM
VERSION: 1.0
USAGE: $("#myForm").validateInput();
ADVANCED USAGE: 
	$("#myForm").validateInput({
		errorColor: '#FFE1E1', // COLOR FOR ERRORS
		passColor: '#FFFFFF', // COLOR FOR VALID INPUT
		fadeTime: 500, // HOW LONG ERRORS TAKE TO FADE IN/OUT
		errorDelay: 3000, // HOW LONG ERROR BOXES DISPLAY BEFORE HIDING
		callBack: '' // FUNCTION TO CALL ON SUBMIT IF EVERYTHING VALIDATES
	};
*/
(function($) {
	$.fn.extend({
		// NAME PLUGIN AND GET PASSED OPTIONS
		validateInput: function (options) {
			// DECLARE DEFAULT OPTIONS
			var defaults = {
				errorColor: '#FFE1E1', // COLOR FOR ERRORS
				passColor: '#FFFFFF', // COLOR FOR VALID INPUT
				fadeTime: 500, // HOW LONG ERRORS TAKE TO FADE IN/OUT
				errorDelay: 3000, // HOW LONG ERROR BOXES DISPLAY BEFORE HIDING
				callBack: '' // FUNCTION TO CALL ON SUBMIT IF EVERYTHING VALIDATES
			}
			
			// ###########################
			// #####  INIT OPTIONS  ######
			// ###########################
			options = $.extend(defaults, options);
			var o = options;
			var formid = $(this).attr('id');
			var errorText = new Array();
			var timers = new Array();
			var noMatch = new Array();
			errorText['string'] = 'Required format: plain text only';
			errorText['number'] = 'Required format: numbers only';
			errorText['phone'] = 'Required format: 555-555-5555';
			errorText['date'] = 'Required format: mm/dd/yyyy';
			errorText['email'] = 'Required format: email@domain.com';
			errorText['len'] = 'Required format: #ERROR#';
			errorText['required'] = 'This field is required';
			var errorStyles = new Array();
			errorStyles.push(".validation_error_box { display: none;position: relative;background: #7d7d7d;background: rgba(0,0,0,0.5);font-size: 0.9em;padding: 3px 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;z-index: 999; }");
			errorStyles.push(".validation_error_box .triangle_down {width: 0;height: 0;border-color: #7d7d7d;border-top: 10px solid rgba(0,0,0,0.5);border-left: 10px solid transparent;border-right: 10px solid transparent;position: absolute;right: 6px;bottom: -10px;z-index: 999; }");
			errorStyles.push(".validation_error_box .triangle_up {width: 0px;height: 0px;border-style: solid;border-width: 0 10px 10px 10px;border-color: transparent transparent rgba(0,0,0,0.5) transparent;line-height: 0px;_border-color: rgba(0,0,0,0.5) rgba(0,0,0,0.5) rgba(0,0,0,0.5) rgba(0,0,0,0.5);_filter: progid:DXImageTransform.Microsoft.Chroma(color='#000000');position: absolute;left: 10px;top: -10px;z-index: 999; }");
			errorStyles.push(".validation_error_box ul {margin: 0;padding: 0;list-style: none; }");
			errorStyles.push(".validation_error_box ul li {margin: 0;color: #FFFFFF; }");
			
			
			// ###########################
			// ########  ON LOAD  ########
			// ###########################
			$("input[data-validate], select[data-validate]").each(function() {
				// GET VALIDATION OPTIONS
				var vOptions = $(this).attr('data-validate').split(' ');
				
				// LOOP THROUGH OPTIONS
				for(i=0;i<vOptions.length;i++) {
					// IF "REQUIRED", ADD ICON
					if(vOptions[i] == 'required') {
						$(this).css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAZdEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41Ljg3O4BdAAABe0lEQVQoU6WRv0tCcRTFr5MV2CRqPBKMV6Yi6CI8lKjBuaU/oKFBKEeHXMshUHBKt16i9EMDU7Cfg+hSg1aoFZpoL6xvLQ2tyelVEARWQxfOcuFzDvdcov/OOpFyz2wWc2Nj8TWivj/9Uhw3fSYIr2WHo7utVs/8CohEAwWXq1zzeFDzepG32yvyTvUjlOb5uYvJyW49n0ejWMS509nd0ekWegKyU39REG4vfT5EIhFEo1Fc+/3Im0z3PVPSo6OLVbcbzVIJwWAQoVAIUrWKysQEUhrN0reUhErFnbhcnatAAO12G6IoIhaLodPpoBkOo8DzT3Gl0vAF7VmtK5WpKbTqdUiShEwmg2w2C8YYHmWo4nQirdWufgBy1yOngvBcm53FTTyOZiKB1sYG2pubkLa2cJdMojE/jyLHvci3mGiZyJizWK6ObTZ2bLWyI7OZHRqN7JDn2YHBwPb1erbPcQ+7avV1kGj8PUShIRocJtLJGuolPZFW9/kPxRsQmbGrNKcdhwAAAABJRU5ErkJggg==')");
						$(this).css('background-repeat','no-repeat');
						$(this).css('background-position','98% 50%');
						$(this).css('padding-right','20px');
					}
				}
			});
			
			// ###########################
			// ###  VALIDATE ON BLUR  ####
			// ###########################
			$("input[data-validate], select[data-validate]").blur(function() {
				// VALIDATE ELEMENT
				var results = validateElement($(this));
				
				// IF VALID
				if(results === true) {
					// REMOVE ALL ERRORS AND CHANGE TO VALID STYLES
					approveElement($(this));
				}
				else {
					// BUILD ERROR MESSAGE AND DISPLAY
					var errorList = buildErrorList(results);
					rejectElement($(this),errorList);
					return false;
				}
			});
			
			// ###########################
			// ##  VALIDATE ON SUBMIT  ###
			// ###########################
			$(this).submit(function() {
				// INIT
				var valid = true;
			
				$("#"+formid+" input[data-validate], #"+formid+" select[data-validate]").each(function() {
					// VALIDATE ELEMENT
					var results = validateElement($(this));
					
					// IF VALID
					if(results === true) {
						// REMOVE ALL ERRORS AND CHANGE TO VALID STYLES
						approveElement($(this));
					}
					else {
						// BUILD ERROR MESSAGE AND DISPLAY
						var errorList = buildErrorList(results);
						rejectElement($(this),errorList);
						valid = false;
					}
				});
				
				// TAKE ACTION BASED ON RESULT
				if(valid) {
					// CHECK FOR CALLBACK
					if(o.callBack != '') {
						// PASS FORM DATA TO CALLBACK
						o.callBack($(this).serialize());
						return false;
					}
					else {
						return true;
					}
				}
				else { return false; }
			});
			
			// ###########################
			// ####  RESET ON FOCUS  #####
			// ###########################
			$("input[data-validate], select[data-validate]").focus(function() {
				// RESET ERROR BOX
				resetElementErrorBox($(this));
				
				// SET ERROR BOX TIMER
				if($(".validation_error_box[data-element-id='"+$(this).attr('id')+"']").length > 0) {
					// DEFINE ERROR BOX
					var errorBox = $(".validation_error_box[data-element-id='"+$(this).attr('id')+"']");
					
					// SHOW ERROR BOX
					errorBox.fadeIn(o.fadeTime);
					
					// SET DISPLAY TIMER
					addTimer();
				}
			});
			
			
			// ###########################
			// ######  FUNCTIONS  ########
			// ###########################
			
			// RESET ERROR BOX FOR ELEMENT
			function resetElementErrorBox(element) {
				// HIDE ERROR BOX
				$(".validation_error_box[data-element-id='"+element.attr('id')+"']").fadeOut(o.fadeTime);
				
				return true;
			}
			
			// REMOVE ERROR BOX FOR ELEMENT
			function removeElementErrorBox(element) {
				$(".validation_error_box[data-element-id='"+element.attr('id')+"']").remove();
				
				return true;
			}
			
			// VALIDATE ELEMENT
			function validateElement(element) {
				// INIT
				var valid = true;
				var errorList = new Array();
				var inputValue = element.val();
			
				// SPLIT VALIDATION OPTIONS INTO ARRAY
				var vOptions = element.attr('data-validate').split(' ');
				
				// LOOP THROUGH ALL VALIDATION OPTIONS
				for(var i=0;i<vOptions.length;i++) {
					// GET OPTION PARAMS IF PRESENT
					regex = /[^[\]]+(?=])/g;
					var params = vOptions[i].match(regex);
					
					// IF PARAMS ARE PRESENT, REMOVE FROM OPTION TO TEST
					if(params) {
						regex = /([A-Za-z0-9])+/g;
						var matches = vOptions[i].match(regex);
						vOptions[i] = matches[0];
					}
				
					// VALIDATE ELEMENT BASED ON OPTION
					switch(vOptions[i]) {
						// VALIDATE STRING
						case 'string':
							if(inputValue != '') {
								regex = /([a-zA-Z0-9\-\'\_]+)/g;
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									errorList.push(errorText['string']);
								}
							}
							break;
							
						case 'number':
							if(inputValue != '') {
								regex = /^\d+$/g;
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									errorList.push(errorText['number']);
								}
							}
							
							break;
							
						case 'phone':
							if(inputValue != '') {
								regex = /([0-9]{3})-([0-9]{3})-([0-9]{4})/g;
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									errorList.push(errorText['phone']);
								}
							}
							
							break;
							
						case 'email':
							if(inputValue != '') {
								regex = /^([A-Za-z0-9\.\-_]+)@([A-Za-z0-9]+)([\.?])([A-Za-z0-9\.]{2,})$/g;
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									errorList.push(errorText['email']);
								}
							}
							
							break;
							
						case 'date':
							if(inputValue != '') {
								regex = /^([0-9]{1,2})[\- \/.]([0-9]{1,2})[\- \/.][\d]{4}$/g;
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									errorList.push(errorText['date']);
								}
							}
							
							break;
							
						case 'match':
							if(inputValue != '') {
								// INIT
								var found = true;
							
								// GET ID AND LABEL OF ELEMENT TO MATCH
								var matchid = params[0];
								var matchLabel = $("label[for='"+matchid+"']").html();
								
								// CHECK IF ELEMENTS MATCH
								if(inputValue != $("#"+matchid).val()) { found = false;	}
								
								if(found === false) {
									valid = false;
									var customError = "Field does not match: "+matchLabel;
									errorList.push(customError);
								}
							}
							
							break;
							
						case 'length':
							if(inputValue != '') {
								// SPLIT LENGTH PARAMS IF NEEDED
								var lenParams = params[0].split(',');
								var lenMin = lenParams[0];
								var lenMax = '';
								if(lenParams.length > 1) { lenMax = lenParams[1]; }
								
								// CREATE REGEX
								regex = "^(.){"+lenMin;
								if(lenMax) {
									regex += ","+lenMax;
								}
								regex += "}$";
								regex = new RegExp(regex);
								
								found = regex.test(inputValue);
								if(found === false) {
									valid = false;
									if(lenMax) {
										var customError = "Minimum Length: "+lenMin;
										errorList.push(customError);
										customError = "Maximum Length: "+lenMax;
										errorList.push(customError);
									}
									else {
										var customError = "Required Length: "+lenMin;
										errorList.push(customError);
									}
									
								}
							}
							
							break;
							
						case 'required':
							if(inputValue == '') {
								valid = false;
								errorList.push(errorText['required']);
							}
							
							break;
					}
				}
				
				// CHECK IF ELEMENT IS VALID
				if(valid === true) { return true; }
				else { return errorList; }
			}
			
			// APPROVE AN ELEMENT
			function approveElement(element) {
				// RESET ERROR BOX AND ERROR STYLES
				//resetElementErrorBox(element);
				removeElementErrorBox(element);
				element.css('background-image','');
			}
			
			// BUILD ERROR LIST
			function buildErrorList(aryErrors) {
				// INIT
				var errorList = '<ul>';
				
				// LOOP THROUGH MESSAGES AND ADD TO LIST
				for(var i=0;i<aryErrors.length;i++) {
					errorList += '<li>*'+aryErrors[i]+'</li>';
				}
				
				// CLOSE LIST
				errorList += '</ul>';
				
				return errorList;
			}
			
			// REJECT AN ELEMENT AND SHOW ERRORS
			function rejectElement(element,errorList) {
				// ADD INLINE STYLES
				if($("#validation_styles").length < 1) {
					var styles = '<style type="text/css" id="validation_styles" id="validation_styles">';
					for(var s=0;s<errorStyles.length;s++) {
						styles += errorStyles[s]+'\n';
					}
					styles += '</style>';
					$("body").prepend(styles);
				}
				
				// CREATE ERROR BOX FOR ELEMENT
				var errorBox = buildErrorBox(element,errorList);
			}
			
			// BUILD ERROR BOX
			function buildErrorBox(element,errorList) {
				// CREATE RANDOM ID
				var randid = Math.floor((Math.random()*100000)+3);
				
				// INIT ERROR BOX
				var errorBox = '<div class="validation_error_box" id="'+randid+'" data-element-id="'+element.attr('id')+'"><div class="triangle_down"></div>';
				
				// CREATE ERROR BOX IF IT DOESN'T EXIST
				if($(".validation_error_box[data-element-id='"+element.attr('id')+"']").length < 1) {
					errorBox += errorList+'</div>';
				}
				else {
					removeElementErrorBox(element);
					errorBox += errorList+'</div>';
				}
				
				// SHOW ERROR BOX
					element.after(errorBox);
					currentBox = $(".validation_error_box[data-element-id='"+element.attr('id')+"']");
					currentBox.fadeIn(o.fadeTime);
				
				// POSITION ERROR BOX
				var elementMarginBottom = parseInt(element.css('margin-bottom').replace('px',''));
				var boxPaddingBottom = parseInt(currentBox.css('padding-bottom').replace('px',''));
				var elementHeight = element.outerHeight();
				var boxHeight = currentBox.outerHeight();
				var offsetHeight = elementHeight + boxHeight + 15;
				var offsetMargin = elementHeight + elementMarginBottom + boxPaddingBottom;
				currentBox.css('margin-top','-'+offsetHeight+'px');
				currentBox.css('margin-right','-'+5+'px');
				currentBox.css('margin-bottom',offsetMargin+'px');
				
				// STYLE ERROR BOX
				element.css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAZdEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41Ljg3O4BdAAABe0lEQVQoU6WRv0tCcRTFr5MV2CRqPBKMV6Yi6CI8lKjBuaU/oKFBKEeHXMshUHBKt16i9EMDU7Cfg+hSg1aoFZpoL6xvLQ2tyelVEARWQxfOcuFzDvdcov/OOpFyz2wWc2Nj8TWivj/9Uhw3fSYIr2WHo7utVs/8CohEAwWXq1zzeFDzepG32yvyTvUjlOb5uYvJyW49n0ejWMS509nd0ekWegKyU39REG4vfT5EIhFEo1Fc+/3Im0z3PVPSo6OLVbcbzVIJwWAQoVAIUrWKysQEUhrN0reUhErFnbhcnatAAO12G6IoIhaLodPpoBkOo8DzT3Gl0vAF7VmtK5WpKbTqdUiShEwmg2w2C8YYHmWo4nQirdWufgBy1yOngvBcm53FTTyOZiKB1sYG2pubkLa2cJdMojE/jyLHvci3mGiZyJizWK6ObTZ2bLWyI7OZHRqN7JDn2YHBwPb1erbPcQ+7avV1kGj8PUShIRocJtLJGuolPZFW9/kPxRsQmbGrNKcdhwAAAABJRU5ErkJggg==')");
				element.css('background-repeat','no-repeat');
				element.css('background-position','98% 50%');
				element.css('padding-right','20px');
				
				// SET DISPLAY TIMER
				addTimer();
			}
			
			// SET ERROR BOX POSITIONING
			function positionErrorBox(element,currentBox) {
				
			}
			
			// SET TIMER
			function addTimer() {
				// CREATE RANDOM ID
				var randid = Math.floor((Math.random()*100000)+3);
				// ADD NEW TIMER
				timers[randid] = setInterval(function(){stopAllTimers(timers)},3000);
			}
			
			// STOP ALL TIMERS
			function stopAllTimers(timers) {
				// HIDE ALL ERROR BOXES
				$(".validation_error_box").fadeOut(o.fadeTime);
				// LOOP THROUGH INTERVALS AND CLEAR
				for(var index in timers) {
					clearInterval(timers[index]);
				}
			}
			
		}
	});
})(jQuery);