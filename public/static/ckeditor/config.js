/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection' ] },
		{ name: 'links' },
		{ name: 'insert', groups: ['insert', 'others', "mediaembed"] },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript,HorizontalRule,Table';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';

  config.extraPlugins = 'oembed,htmlbuttons,mediaembed'
  config.allowedContent = true // don't remove embedded iframes

  config.htmlbuttons = [
  	{
  		name:'gallery',
  		icon:'gallery.png',
  		html:'{gallery}',
  		title:'Insert Gallery Tag'
  	}
  ];

  // Don't convert unicode characters to HTML entities,
  // this hurts full-text DB search.
  config.entities_latin = false

  // Always use English
  config.language = "en"
};

// Setup dialogs. Link target "_blank" by default.
CKEDITOR.on( 'dialogDefinition', function( ev ) {
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  if ( dialogName == 'link' )
  {
    var targetTab = dialogDefinition.getContents( 'target' );
    var targetField = targetTab.get( 'linkTargetType' );
    targetField[ 'default' ] = '_blank';
  }
});
