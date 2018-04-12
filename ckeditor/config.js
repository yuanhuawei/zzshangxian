/*
Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.skin = 'moonocolor';
	
	config.toolbar = [
		['Source','-','Preview','-','Templates'],
		['PasteText','PasteFromWord','-'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Table','HorizontalRule','Smiley','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Maximize','ShowBlocks','Typeset','Code','Iframe','About']//,'Save']
	];

	
	//config.extraPlugins = 'typeset,code,tableresize';

	config.autoUpdateElement = true;
	CKEDITOR.config.allowedContent = true;
	config.resize_enabled = false;

	config.toolbarCanCollapse = false;
	config.scayt_autoStartup = false;
	config.autoParagraph = false;

	//tab
	config.tabSpaces = 2;
	config.tabText = String.fromCharCode(12288);
	config.enableTabKeyTools = true;
	
	//config.baseHref = P8CONFIG.RESOURCE +'/ckeditor/';


	config.font_names = '宋体;黑体;细黑;隶书;微软雅黑;楷体;'+
		'Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;'+
		'Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;'+
		'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;'+
		'Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;'
		'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif';


	config.pasteFromWordRemoveFontStyles = false;
	config.pasteFromWordRemoveStyles = false;
}