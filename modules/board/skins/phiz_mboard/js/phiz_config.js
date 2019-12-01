jQuery(document).ready(function($){
	CKEDITOR.editorConfig = function( config ) {
	config.autoGrow_onStartup = true;
	config.extraPlugins = 'autogrow';
	config.autoGrow_minHeight = 120;
	config.autoGrow_maxHeight = 300;
	config.autoGrow_bottomSpace = 5;
	config.removePlugins = "toolbar,elementspath";
	config.resize_enabled = false;

	};

});
