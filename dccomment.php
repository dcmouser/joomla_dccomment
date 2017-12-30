<?php
/**
 * @version		$Id: dcfunctions.php 1.- 11/02/16 mouser@donationcoder.com $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2017 by mouser@donationcoder.com. All rights reserved.
 * @license		TBD
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// based on code from https://docs.joomla.org/J3.x:Creating_a_content_plugin

class PlgContentDccomment extends JPlugin {
	
	public function onContentPrepare($context, &$article, &$params, $page = 0) {

		// Quick efficient check to see if we see our tag anywhere, if not we can stop right now.
		if (strpos($article->text, '{dccomment') === false) {
			return true;
		}
		
		// content is article text
		$content = $article->text;

		// our regex for our tag (the s ensures its not greedy, which is important if we have multiple tags)
		$regex = '/{dccomment([^\}]*?)}(.*?)\{\/dccomment([^\}]*?)}/s';

	
		// Don't run this plugin when the content is being indexed?
		if ($context == 'com_finder.indexer') {
			// in sample code you will see a simple "return true" here, but we don't want that we want to CLEAR the {dcf}...{/dcf} content so it doesn't get indexed.
			$content = preg_replace($regex, '', $content);
			$article->text = $content;
			// now return with no returnval to say we changed it
			return;
		}

	// just remove the content
	$content = preg_replace($regex, '', $content);
	$article->text = $content;
	// now return with no returnval to say we changed it
	return;
	}
	

}


