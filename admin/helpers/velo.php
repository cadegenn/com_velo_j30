<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * velo component helper.
 */
abstract class veloHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		switch ($submenu) {
			case 'velos':	JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_VELOS'), 'index.php?option=com_velo&view=velos', true);
							//JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_MODELS'), 'index.php?option=com_velo&view=parts', true);
							break;
			case 'matos':	JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_MARQUES'), 'index.php?option=com_velo&view=marques', true);
							JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_MODELS'), 'index.php?option=com_velo&view=parts', true);
							break;
			case 'config' :	JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_MATERIAUX'), 'index.php?option=com_velo&view=materiaux', true);
							JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_TYPES'), 'index.php?option=com_velo&view=types', true);
							JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_COMPOSANTS'), 'index.php?option=com_velo&view=composants', true);
							JSubMenuHelper::addEntry(JText::_('COM_VELO_SUBMENU_SPECS'), 'index.php?option=com_velo&view=specs', true);
							break;
		}
		// set some global property
		/*$document = JFactory::getDocument();
		//$document->addStyleDeclaration('.icon-48-categories ' .
		//                               '{background-image: url(../components/com_velo/images/ico-48x48/velo.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_VELO_ADMINISTRATION_CATEGORIES'));
		}*/
	}
}
?>
