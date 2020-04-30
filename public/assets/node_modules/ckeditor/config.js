/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
 jQuery(document).ready(function($) {
 	var curr_url1 = window.location.href;
 	curr_url2 = curr_url1.split('/admin');
 	newfilebrowserBrowseUrl  = curr_url2[0]+'/admin/aws';
 	newfilebrowserUploadUrl = curr_url2[0]+'/admin/ajaxhandleruploadbyck?_token=' + $('meta[name=csrf-token]').attr("content");
 });
CKEDITOR.editorConfig = function( config ) {
	config.height =  100,
	config.extraPlugins =  'autogrow',
	config.autoGrow_minHeight =  100,
	config.autoGrow_maxHeight =  250,
	config.autoGrow_bottomSpace =  0,
	config.enterMode  =  Number(1),
	config.shiftEnterMode  =  Number(2),
	config.autoParagraph  =  false,
	// config.filebrowserBrowseUrl  =  newfilebrowserBrowseUrl,
	// config.filebrowserImageBrowseUrl  =  newfilebrowserBrowseUrl,
	// config.filebrowserFlashBrowseUrl  =  newfilebrowserBrowseUrl,
	config.filebrowserUploadUrl  =  newfilebrowserUploadUrl,
	config.filebrowserImageUploadUrl  =  newfilebrowserUploadUrl,
	config.filebrowserFlashUploadUrl  =  newfilebrowserUploadUrl,
	config.filebrowserUploadMethod= 'form'
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
