/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.allowedContent = true;
	//config.protectedSource.push( /<\?[\s\S]*?\?>/g ); 
	config.protectedSource.push( /<i [\s\S]*?\i>/g ); 
        config.enterMode = CKEDITOR.ENTER_BR;
        
	//config.protectedSource.push( /<article[\s\S]*?\article>/g ); 
        //config.protectedSource.push( /<aside[\s\S]*?\aside>/g ); 
};
