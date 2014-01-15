<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of chantiers component
 */
class veloController extends JController {
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		//JRequest::setVar('view', JRequest::getCmd('view', 'velo'));
		$input = JFactory::getApplication()->input;
		$input->set('i', $input->getCmd('view', 'velo'));
 
		// call parent behavior
		parent::display($cachable);
		
		//veloHelper::addSubmenu('chantiers');	// => admin/helpers/chantiers.php
	}
}

?>
