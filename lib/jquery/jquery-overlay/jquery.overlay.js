/*
/ PLUGIN NAME: OVERLAY FOR JQUERY
/ DESCRIPTION: QUICKLY ADDS AN OVERLAY (AKA POP-UP) TO A PAGE
/ AUTHOR: DARIUS BABCOCK
/ VERSION: 1.0
/ USAGE: $("#myButton").click(function() {
/		$.overlay({
/			content: "<p>Hello world!</p>"
/		});
/ });
/ ADVANCED USAGE: $("#myButton").click(function() {
/		$.overlay({
/			overlayId: 'myOverlay', // ID OF THE OVERLAY BEING CREATED
/			content: "<p>Hello world!</p>", // CONTENT OF THE OVERLAY
/			prependTo: 'body', // INSERT OVERLAY AT BEGINNING OF THIS ELEMENT
/			insertBeforeId: 'myID', // TRUMPS prependTo, INSERTS OVERLAY BEFORE ID
/			overlayClass: 'newClass', // CHANGES THE CLASS OF THE OVERLAY
/			overlayAddClass: 'newClass1 newClass2', // ADDS CLASS(ES) TO THE OVERLAY
/			maskId: 'mask', // DEFINES THE MASK ID TO SHOW WITH OVERLAY
/			overlayWidth: '30.6em', // OVERRIDES CSS WIDTH. ANY UNIT (EM,PX,etc.)
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
				overlayContent: '',
				maskId: 'mask',
				overlayWidth: '',
				fadeTime: 500
			}
			
			var options = $.extend(defaults, options);
			var o = options;
			
			// IF NO ID, GENERATE ONE
			if(o.overlayId == '') {
				o.overlayId = "overlay_"+Math.floor((Math.random()*100000)+3);
			}
			
			// REMOVE EXISTING OVERLAY OF THIS ID, IF PRESENT
			if($("#"+o.overlayId).length > 0) {
				$("#"+o.overlayId).remove();
			}
			
			// GET WINDOW POSITION & HEIGHT
			var offset = $(window).scrollTop();
			var height = $(window).height();
			var percent = '0.05';
			percent = height*percent;
			
			// CREATE OVERLAY
			if(o.insertBeforeId == '') {
				$(o.prependTo).prepend("<div id='"+o.overlayId+"' class='"+o.overlayClass+" "+o.overlayAddClass+"'><div class='close_overlay'></div>"+o.overlayContent+"</div>");
			}
			else {
				$("<div id='"+o.overlayId+"' class='"+o.overlayClass+" "+o.overlayAddClass+"'><div class='close_overlay'></div>"+o.overlayContent+"</div>").insertBefore("#"+o.insertBeforeId);
			}
			$("#"+o.overlayId).css('top',offset+percent);
			$("#"+o.maskId+", #"+o.overlayId).fadeIn(o.fadeTime);
			if(o.overlayWidth != '') {
				var width = o.overlayWidth.match(/[\d\.]{1,}/gi);
				var measure = o.overlayWidth.match(/[\D]{2}/gi);
				var newWidth = width/2;
				
				$("#"+o.overlayId).css('width',width+measure);
				$("#"+o.overlayId).css('margin-left','-'+newWidth+measure);
			}
		}
	});
})(jQuery);