(function() {
tinymce.create('tinymce.plugins.WufooIntegration', {
	getInfo : function() {
		return {
			longname : 'WufooIntegration',
			author : 'Mint Reaction',
			authorurl : 'http://mintreaction.com',
			infourl : 'http://mintreaction.com',
			version : "1.0"
		};
	},

	init : function(ed, url) {

		ed.addCommand('openWufooDialog', function() {
			if ( 'undefined' != typeof wufooWPadmin ) {
				wufooWPadmin.clickOpenDialogButton.call(ed);
			}
		});

		ed.addButton('WufooIntegration', {
			title : 'Open Wufoo Dialog',
			cmd : 'openWufooDialog',
			// image : url.replace(/js$/, 'images/wufoo-tinymce-button.png')
			image : url.replace(/js$/, 'images/wufoo-button.png')
		});
	}
}); 
tinymce.PluginManager.add('WufooIntegration', tinymce.plugins.WufooIntegration);
})();
