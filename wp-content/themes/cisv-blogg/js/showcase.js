(function($) {
	$(document).ready( function() {
	    $('.feature-slider a').click(function(e) {
	        $('.featured-posts section.featured-post').css({
	            opacity: 0,
	            visibility: 'hidden'
	        });
	        $(this.hash).css({
	            opacity: 1,
	            visibility: 'visible'
	        });
	        $('.feature-slider a').removeClass('active');
	        $(this).addClass('active');
	        e.preventDefault();
	    });
	});
	var current=1;
	function autoAdvance(){
		if(current==-1) return false;
		$('.feature-slider a').eq(current%$('.feature-slider a').length).trigger('click',[true]);	// [true] will be passed as the keepScroll parameter of the click function on line 28
		current++;
	}
	// The number of seconds that the slider will auto-advance in:
	var changeEvery = 5;
	var itvl = setInterval(function(){autoAdvance()},changeEvery*1000);
})(jQuery);