jQuery(document).ready(function(){
	jQuery('.sociable-img').hover(
		function(e) {
			// First parent = <a>, next parent is <span>
			var tip = jQuery(this).parent().next('.fg-tooltip');
			var x = jQuery(this).position().left + (jQuery(this).width() / 2) - (jQuery(tip).width() / 2) - 6;
			var y = jQuery(this).position().top- jQuery(tip).height() - 12;

			jQuery(tip).css('top', y);
			jQuery(tip).css('left', x);
			jQuery(tip).show();
			return false;
		},

		function(e) {
			var tip = jQuery(this).parent().next('.fg-tooltip');
			jQuery(tip).hide();
		}
	);

});
