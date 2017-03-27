/*

Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.

For licensing, see LICENSE.html or http://ckeditor.com/license

*/



CKEDITOR.editorConfig = function( config )

{

	// Define changes to default configuration here. For example:

	// config.language = 'fr';

	// config.uiColor = '#AADC6E';

	config.contentsCss = 'contents.css';
	
	config.toolbar = 'Basic';
	
	config.toolbar_Full =
	[
		{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
			'HiddenField' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
	
	config.toolbar_Basic =
	[
		['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
	];

	//the next line add the new font to the combobox in CKEditor

	config.font_names = 'Ganashakti/Ganashakti;' + config.font_names;

	config.font_names = 'GanashaktiBold/GanashaktiBold;' + config.font_names;

	config.font_names = 'GanashaktiItalic/GanashaktiItalic;' + config.font_names;

	config.font_names = 'GanashaktiBoldItalic/GanashaktiBoldItalic;' + config.font_names;

};