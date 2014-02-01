<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_velo (largement pompé sur la version com_content)
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Content Component HTML Helper
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_velo
 * @since 1.5
 */
class JHtmlButton
{
	/*
	 * @brief	draw a button using bootstrap's glyphs
	 * @param	$glyph		name of glyph to use. it is used to build the classes.
	 * @example	$glyph = "question-sign" will build the "glyphicon glyphicon-question-sign" glyph
	 * @param	$class		custom class to add to the glyph
	 * @param	$url		url to go to when clicking on the button
	 */
	function _default($glyph = "question-sign", $class = "", $url = "#") {
			return self::button("default", $glyph, $class, $url);
	}

	/*
	 * @brief	draw a link-typed button using bootstrap's glyphs
	 * @param	$glyph		name of glyph to use. it is used to build the classes.
	 * @example	$glyph = "question-sign" will build the "glyphicon glyphicon-question-sign" glyph
	 * @param	$class		custom class to add to the glyph
	 * @param	$url		action to execute when clicking on the button
	 */
	function link($glyph = "question-sign", $class = "", $url = "#") {
			return self::button("link", $glyph, $class, $url);
	}

	/*
	 * @brief	draw a button using bootstrap's glyphs
	 * @param	$type		type of button : [default|primary|success|info|warning|danger|link]
	 * @param	$glyph		name of glyph to use. it is used to build the classes.
	 * @example	$glyph = "question-sign" will build the "glyphicon glyphicon-question-sign" glyph
	 * @param	$class		custom class to add to the glyph
	 * @param	$url		action to execute when clicking on the button
	 */
	function button($type = "default", $glyph = "question-sign", $class = "", $url = "#") {
		//$el = "<button class='btn btn-".$type."' onclick='javascript:window.location(\"".$url."\");'><span class='glyphicon glyphicon-".$glyph." ".$class."'></span></button>";
		$el = "<a class='btn btn-".$type."' href='".$url."'><span class='glyphicon glyphicon-".$glyph." ".$class."'></span></a>";
		return $el;
	}

}

?>