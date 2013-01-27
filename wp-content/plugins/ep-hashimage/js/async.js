jQuery(document).ready(function($) {
	$(".hashimage-container").each(function(i,e){
		// Get options
		var options = $(this).data('options');
		// Get async status
		var async = options.async;
		// Get refresh status
		var refresh = options.refresh;
		// Get dataurl
		var dataurl = options.pluginpath+'?limit='+options.limit+'&hashtag='+options.hashtag+'&refresh='+options.refresh+'&type='+options.type+'&asyncload=true';
		// lightbox link
		var link_path = '.hashimage-container li a';

		if(async == 'true') {
			// if refresh is true
			if(refresh == 'true') {
				getImages(this, link_path, dataurl);
				setInterval(function(){
					getImages(this, link_path, dataurl);
				}, 900000); // 900 000
			// else, just load
			} else {
				getImages(this, link_path, dataurl);
			}
		}
	});

	function getImages(element, links, dataurl) {
		$(element).load(dataurl, function(){
			$(element).find('p').fadeOut();
			$(links).each(function() {
				if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
					jQuery(function($) {
						$("a[rel^='lightbox']").slimbox({/* Put custom options here */}, null, function(el) {
							return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
						});
					});
				}
			});
		});
	}
});