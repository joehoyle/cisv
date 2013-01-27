jQuery(function ($) {

$(window).load(function () {

		$('#upz-slideshow-display').cycle({ 
		fx:     fx, 
		speed:  transitionspeed, 
		timeout: timeout, 
		pager:  '#upz-slideshow-navigation', 
		pagerAnchorBuilder: function(idx, slide) { 
			// return selector string for existing anchor 
			return '#upz-slideshow-navigation li:eq(' + idx + ')'; 
		}     
	}); 

})
});