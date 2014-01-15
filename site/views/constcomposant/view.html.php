<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
 
/**
 * HTML View class for the ConstComposant Component
 */
class veloViewConstComposant extends JView
{
	// Overwriting JView display method
	function display($tpl = null)  {
		$app            = JFactory::getApplication();
		$params         = $app->getParams();
		$dispatcher = JDispatcher::getInstance();

		// Get some data from the models
		$this->user = VELOdb::getCurrentUser();
		//$id		= intval(JRequest::getVar('id', 0, 'get', 'int'));
		//$item   = $this->get('Item');
		$form   = $this->get('Form');
		$state  = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
        $this->form = $form;
		//$this->item = $item;
		$this->state = $state;

		// add some styles
		$doc = JFactory::getDocument();
		$doc->addStyleSheet('components/com_velo/css/admin.css');

		// add breadcrumbs
		$app    = JFactory::getApplication();
		$pathway = $app->getPathway();
		$pathway->addItem(JText::_('COM_VELO_PROPOSE_COMPONENT'), 'index.php?option='.JRequest::getVar('option', '0', 'get', 'string').'&view='.$this->view.'&layout='.$this->layout.'&Itemid='.JRequest::getVar('Itemid', 0, 'get','int'));

		// Display the view
		parent::display($tpl);
	}
}