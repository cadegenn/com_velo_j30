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
class JHtmlGlyph
{
    static function create($category, $params)
    {
            $uri = JFactory::getURI();

            $url = 'index.php?option=com_velo&view=monvelo&view=edit&id=0&return='.base64_encode($uri);

            if ($params->get('show_icons')) {
                    $text = JHtml::_('image', 'system/new.png', JText::_('JNEW'), NULL, true);
            } else {
                    $text = JText::_('JNEW').'&#160;';
            }

            $button =  JHtml::_('link', JRoute::_($url), $text);

            $output = '<span class="hasTip" title="'.JText::_('COM_CONTENT_CREATE_ARTICLE').'">'.$button.'</span>';
            return $output;
    }

    static function email($item, $params, $attribs = array())
    {
            require_once JPATH_SITE . '/components/com_mailto/helpers/mailto.php';
            $uri	= JURI::getInstance();
            $base	= $uri->toString(array('scheme', 'host', 'port'));
            $template = JFactory::getApplication()->getTemplate();
            //$link	= $base.JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid) , false);
            $link	= $base.'/index.php?option=com_velo&view=monvelo&id='.$item->id;
            $url	= 'index.php?option=com_mailto&tmpl=component&template='.$template.'&link='.MailToHelper::addLink($link);

            $status = 'width=400,height=350,menubar=yes,resizable=yes';

			$component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
			$glyph = 'glyphicons_010_envelope.png';
			
            if ($params->get('show_icons')) {
					$text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JGLOBAL_EMAIL')."' title='".JText::_('JGLOBAL_EMAIL')."' />";
            } else {
                    $text = '&#160;'.JText::_('JGLOBAL_EMAIL');
            }

            $attribs['title']	= JText::_('JGLOBAL_EMAIL');
            $attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";

            $output = JHtml::_('link', JRoute::_($url), $text, $attribs);
            return $output;
    }

    /**
     * Display an edit icon for the article.
     *
     * This icon will not display in a popup window, nor if the article is trashed.
     * Edit access checks must be performed in the calling code.
     *
     * @param	string	$component	the component to edit
     * @param	string	$view		the view of the component to edit
     * @param	string	$layout		the layout of the view
     * @param	object	$item		The item in question.
     * @param	object	$params		The item parameters
     * @param	array	$attribs	Not used??
     *
     * @return	string	The HTML for the article edit icon.
     * @since	1.6
     */
    static function edit($component, $view, $layout='edit', $item, $params, $attribs = array())
    {
            // Initialise variables.
            $user	= JFactory::getUser();
            $userId	= $user->get('id');
            $uri	= JFactory::getURI();

            $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
            $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
            //$layout = ($layout != '' ? $layout : JRequest::getVar('layout', null, 'get', 'string'));

            // Ignore if in a popup window.
            if ($params && $params->get('popup')) {
                    return;
            }

            // Ignore if the state is negative (trashed).
            if ($item->published < 0) {
                    return;
            }

            JHtml::_('behavior.tooltip');

            // Show checked_out icon if the article is checked out by a different user
            /*if (property_exists($item, 'checked_out') && property_exists($item, 'checked_out_time') && $item->checked_out > 0 && $item->checked_out != $user->get('id')) {
                    $checkoutUser = JFactory::getUser($item->checked_out);
                    $button = JHtml::_('image', 'system/checked_out.png', NULL, NULL, true);
                    $date = JHtml::_('date', $item->checked_out_time);
                    $tooltip = JText::_('JLIB_HTML_CHECKED_OUT').' :: '.JText::sprintf('COM_CONTENT_CHECKED_OUT_BY', $checkoutUser->name).' <br /> '.$date;
                    return '<span class="hasTip" title="'.htmlspecialchars($tooltip, ENT_COMPAT, 'UTF-8').'">'.$button.'</span>';
            }*/

            $url	= 'index.php?option='.$component.'&view='.$view.'&layout='.$layout.'&id='.$item->id.'&return='.base64_encode($uri);
            switch ($item->published) {
                    case -2	:	// DELETED => SOLD
                                            $glyph = 'edit_sold.png';
                                            $overlib = JText::_('COM_VELO_PART_STATUS_TRASHED');
                                            break;
                    case 0	:	// UNPUBILSHED => IN STOCK
                                            $glyph = 'edit_unpublished.png';
                                            $overlib = JText::_('COM_VELO_PART_STATUS_UNPUBLISHED');
                                            break;
                    case 1	:	// PUBILSHED => MOUNTED ON A BIKE
                                            $glyph = 'edit.png';
                                            $overlib = JText::_('COM_VELO_PART_STATUS_PUBLISHED');
                                            break;
                    case 2	:	// ARCHIVED => IN THE WISHLIST
                                            $glyph = 'edit_unpublished.png';
                                            $overlib = JText::_('COM_VELO_PART_STATUS_ARCHIVED');
                                            break;
                    default	:	// UNPUBILSHED
                                            $glyph = 'edit_unpublished.png';
                                            $overlib = JText::_('COM_VELO_PART_STATUS_UNPUBLISHED');
                                            break;
            }
            $attribs['style'] = $item->published ? 'margin: -4px -2px 0 -2px' : 'margin: -4px -2px 0 -4px';		// default images are not 16x16px :-( and worse... are not same size
            $text	= JHtml::_('image', 'system/'.$glyph, JText::_('JGLOBAL_EDIT'), $attribs, true);

            /*if ($item->published == 0) {
                    $overlib = JText::_('JUNPUBLISHED');
            }
            else {
                    $overlib = JText::_('JPUBLISHED');
            }*/

            $date = JHtml::_('date', $item->creation_date);
            $author = $item->created_by;

            $overlib .= '&lt;br /&gt;';
            $overlib .= $date;
            $overlib .= '&lt;br /&gt;';
            $overlib .= JText::sprintf('COM_VELO_WRITTEN_BY', htmlspecialchars($author, ENT_COMPAT, 'UTF-8'));

            $button = JHtml::_('link', JRoute::_($url), $text);

            $output = '<span class="hasTip" title="'.JText::_('JACTION_EDIT').' :: '.$overlib.'">'.$button.'</span>';

            return $output;
    }


    static function print_popup($item, $params, $attribs = array())
    {
            //$url  = ContentHelperRoute::getArticleRoute($item->slug, $item->catid);
            $url  = 'index.php?option=com_velo&view=monvelo&id='.$item->id;
            $url .= '&tmpl=component&print=1&layout=default&page='.@ $request->limitstart;

            $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

			$component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
			$glyph = 'glyphicons_015_print.png';
			
            // checks template image directory for image, if non found default are loaded
            if ($params->get('show_icons')) {
                    $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JGLOBAL_PRINT')."' title='".JText::_('JGLOBAL_PRINT')."' />";
            } else {
                    $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JGLOBAL_PRINT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
            }

            $attribs['title']	= JText::_('JGLOBAL_PRINT');
            $attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
            $attribs['rel']		= 'nofollow';

            return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    static function print_screen($item, $params, $attribs = array())
    {
            // checks template image directory for image, if non found default are loaded
            if ($params->get('show_icons')) {
                    $text = JHtml::_('image', 'system/printButton.png', JText::_('JGLOBAL_PRINT'), NULL, true);
            } else {
                    $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JGLOBAL_PRINT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
            }
            return '<a href="#" onclick="window.print();return false;">'.$text.'</a>';
    }

    /**
     * @brief	method		draw icon to add bike component
     * @param type $item	bike object
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function add_component($item, $params, $attribs = array()) {
            $uri	= JFactory::getURI();
			$component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
            $url  = 'index.php?option=com_velo&view=moncomposant&velo_id='.$item->id.'&layout=edit&return='.base64_encode($uri);
            $glyph = 'glyphicons_190_circle_plus.png';

            if ($params->get('show_icons')) {
                    //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                    $text = "<img src='".JURI::base()."/components/".$component."/images/ico-24x24/glyphicons/".$glyph."' alt='".JText::_('COM_VELO_ADD_COMPONENT')."' title='".JText::_('COM_VELO_ADD_COMPONENT')."' />";
            } else {
                    $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_VELO_ADD_COMPONENT') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
            }

            return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    /**
     * @brief	method		draw icon to add a bike
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function new_bike($params, $attribs = array()) {
            $uri	= JFactory::getURI();
            $url  = 'index.php?option=com_velo&view=monvelo&layout=edit';
			$component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
			$glyph = 'glyphicons_306_bicycle.png';
			

            if ($params->get('show_icons')) {
                    //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                    $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('COM_VELO_ADD_VELO')."' title='".JText::_('COM_VELO_ADD_VELO')."' />";
            } else {
                    $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('COM_VELO_ADD_VELO') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
            }

            return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    /**
     * @brief	method		draw icon to delete an item
     * @param type $item	object to delete
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function delete($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.supprimer&'.JUtility::getToken().'=1&return='.base64_encode($uri);
        $glyph = 'glyphicons_197_remove.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_DELETE')."' title='".JText::_('JACTION_DELETE')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_DELETE') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        // confirm before delete
        $attribs['onclick'] = "if (confirm('".JText::_('COM_VELO_AREYOUSURE')."')){
                href = '".$url."';
                window.location.href = encodeURIComponent(href);
        }";

        return JHtml::_('link', '#'/*JRoute::_($url)*/, $text, $attribs);
    }

    /**
     * @brief	method		draw icon to attach an item
     * @param type $item	object to attach
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function attach($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.attacher&'.JUtility::getToken().'=1&return='.base64_encode($uri);
        $glyph = 'glyphicons_386_log_in.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_ATTACH')."' title='".JText::_('JACTION_ATTACH')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_ATTACH') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    /**
     * @brief	method		draw icon to detach an item
     * @param type $item	object to detach
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function detach($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.detacher&'.JUtility::getToken().'=1&return='.base64_encode($uri);
        $glyph = 'glyphicons_387_log_out.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_DETACH')."' title='".JText::_('JACTION_DETACH')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_DETACH') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        // confirm before delete
        $attribs['onclick'] = "if (confirm('".JText::_('COM_VELO_AREYOUSURE')."')){
                href = '".$url."';
                window.location.href = encodeURIComponent(href);
        }";

        return JHtml::_('link', '#'/*JRoute::_($url)*/, $text, $attribs);
    }

    /**
     * @brief	method		draw icon to duplicate an item
     * @param type $item	object to detach
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function duplicate($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.dupliquer&'.JUtility::getToken().'=1&return='.base64_encode($uri);
        $glyph = 'page_copy.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_DUPLICATE')."' title='".JText::_('JACTION_DUPLICATE')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_DUPLICATE') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    /**
     * @brief	method		draw icon to show list of items of same model_id
     * @param type $item	object to detach
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function show_list($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&layout=default_list&id='.$item->id.'&model_id='.$item->model_id.'&return='.base64_encode($uri);
        $glyph = 'application_view_detail.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_DETAILS')."' title='".JText::_('JACTION_DETAILS')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_DETAILS') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

    /**
     * @brief	method		draw icon to put an item into stock
     * @param type $item	object to detach
     * @param type $params	component parameters (article's parameters from com_content)
     * @param type $attribs	array
     * @return type			HTML code
     */
    static function putInStock($component, $view, $item, $params, $attribs = array()) {
        $uri	= JFactory::getURI();
        $component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
        $view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
        $Itemid = JRequest::getVar('Itemid', 0, 'get','int');
        $url  = 'index.php?option='.$component.'&view='.$view.'&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.stocker&'.JUtility::getToken().'=1&return='.base64_encode($uri);
        $glyph = 'glyphicons_049_star.png';

        if ($params->get('show_icons')) {
                //$text = JHtml::_('image', 'ico_24x24/glyphicons/'.$glyph, JText::_('COM_VELO_ADD_COMPONENT'), NULL, true);
                $text = "<img src='".JURI::base()."/components/".$component."/images/ico_24x24/glyphicons/".$glyph."' alt='".JText::_('JACTION_PUTINSTOCK')."' title='".JText::_('JACTION_PUTINSTOCK')."' />";
        } else {
                $text = JText::_('JGLOBAL_ICON_SEP') .'&#160;'. JText::_('JACTION_PUTINSTOCK') .'&#160;'. JText::_('JGLOBAL_ICON_SEP');
        }

        return JHtml::_('link', JRoute::_($url), $text, $attribs);
    }

}
