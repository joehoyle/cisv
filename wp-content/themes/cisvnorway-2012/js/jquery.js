jQuery(document).ready(function($) {
	$('.hide,#searchform').hide();
	$('.show').click(function(ev){
		ev.preventDefault();
		$('.show,#introtekst').hide();
		$('.hide,#searchform').show();
	});
	$('.hide').click(function(ev){
		ev.preventDefault();
		$('.hide,#searchform').hide();
		$('.show, #introtekst').show();
	});
}); 