/*
/ PLUGIN NAME: OVERLAY FOR JQUERY
/ DESCRIPTION: QUICKLY ADDS AN OVERLAY (AKA POP-UP) TO A PAGE
/ AUTHOR: DARIUS BABCOCK
/ VERSION: 1.0
/ USAGE: $("#myButton").click(function() {
/		 	$.overlay({
/				overlayContent: "<p>Hello world!</p>"
/			});
/ 		 });
/ ADVANCED USAGE: $("#myButton").click(function() {
/		$.overlay({
/			overlayId: 'myOverlay', // ID OF THE OVERLAY BEING CREATED
/			overlayContent: "<p>Hello world!</p>", // CONTENT OF THE OVERLAY
/           overlayHeader: '', // GIVE A HEADER TO THE OVERLAY
/			prependTo: 'body', // INSERT OVERLAY AT BEGINNING OF THIS ELEMENT
/			insertBeforeId: 'myID', // TRUMPS prependTo, INSERTS OVERLAY BEFORE ID
/			overlayClass: 'newClass', // CHANGES THE CLASS OF THE OVERLAY
/			overlayAddClass: 'newClass1 newClass2', // ADDS CLASS(ES) TO THE OVERLAY
/			maskId: 'mask', // DEFINES THE MASK ID TO SHOW WITH OVERLAY
/			overlayWidth: '30.6em', // OVERRIDES CSS WIDTH. ANY UNIT (EM,PX,etc.)
/			overlayHeight: '30.6em', // OVERRIDES CSS HEIGHT. ANY UNIT (EM,PX,etc.)
/			fadeTime: 500 // DURATION IN MS OF FADE
/		});
/ });	
*/
(function($) {
	$.extend({
		overlay: function (options) {
			var defaults = {
				prependTo: 'body',
				insertBeforeId: '',
				overlayId: '',
				overlayClass: 'overlay',
				overlayAddClass: '',
				overlayHeader: '',
				overlayContent: '',
				maskId: 'mask',
				overlayWidth: '',
				overlayHeight: '',
				fadeTime: 500
			}
			
			var options = $.extend(defaults, options);
			var o = options;
			
			// IF NO ID, GENERATE ONE
			if(o.overlayId == '') {
				o.overlayId = "overlay_"+Math.floor((Math.random()*100000)+3);
			}
			
			// REMOVE EXISTING OVERLAY OF THIS ID, IF PRESENT
			$(".overlay").remove();
			if($("#"+o.overlayId).length > 0) {
				$("#"+o.overlayId).remove();
			}
			
			// GET WINDOW POSITION & HEIGHT
			var offset = $(window).scrollTop();
			var height = $(window).height();
			var percent = '0.05';
			percent = height*percent;
			
			// CREATE HEADER IF SPECIFIED
			if(o.overlayHeader != '') {
				o.overlayHeader = "<span class='overlay_header'>"+o.overlayHeader+"</span>"
			}
			else { o.overlayHeader = "<span class='overlay_header'>&nbsp;</span>" }
			
			// CREATE OVERLAY
			var overlay_code = "<div id='"+o.overlayId+"' class='"+o.overlayClass+" "+o.overlayAddClass+"'><div class='close_overlay'></div>"+o.overlayHeader+"<div id='"+o.overlayId+"_scrollbox' class='overlay_content'>"+o.overlayContent+"</div></div>";
			
			if(o.insertBeforeId == '') {
				// PREPEND TO "PREPENDTO" ELEMENT
				$(o.prependTo).prepend(overlay_code);
			}
			else {
				// INSERT BEFORE "INSERTBEFOREID" ELEMENT
				$(overlay_code).insertBefore("#"+o.insertBeforeId);
			}
			//$("#"+o.overlayId).css('top',offset+percent);
			$("#"+o.maskId+", #"+o.overlayId).fadeIn(o.fadeTime);
			
			// IF A CUSTOM WIDTH IS GIVEN, APPLY IT
			if(o.overlayWidth != '') {
				var width = o.overlayWidth.match(/[\d\.]{1,}/gi);
				var measure = o.overlayWidth.match(/[\D]{2}/gi);
				if(!measure) { measure = 'px'; }
				var newWidth = width/2;
				
				$("#"+o.overlayId).css('width',width+measure);
				$("#"+o.overlayId).css('margin-left','-'+newWidth+measure);
			}
			
			// IF A CUSTOM HEIGHT IS GIVEN, APPLY IT
			if(o.overlayHeight != '') {
				var height = o.overlayHeight.match(/[\d\.]{1,}/gi);
				var measure = o.overlayHeight.match(/[\D]{2}/gi);
				if(!measure) { measure = 'px'; }
				var newHeight = height/2;
				
				$("#"+o.overlayId).css('height',height+measure);
				$("#"+o.overlayId).css('margin-top','-'+newHeight+measure);
			}
			
			// DEFAULT CLOSE BEHAVIOR
			$(".close_overlay").click(function() {
				$(this).parent().remove();
			});
			
			// IF JQUERY CUSTOM SCROLLBARS HAS BEEN LOADED, APPLY THEM
			if(jQuery().mCustomScrollbar) {
				$(".overlay_content").mCustomScrollbar({
					theme: "dark-2",
					autoDraggerLength: true,
					scrollButtons:{
						enable: true
					},
					advanced:{
						updateOnContentResize: true
					}
				});
				
			}
		}
	});
})(jQuery);