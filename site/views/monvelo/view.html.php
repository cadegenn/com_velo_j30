<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
 
/**
 * HTML View class for the MonVelo Component
 */
class veloViewMonVelo extends JView
{
	// Overwriting JView display method
	function display($tpl = null)  {
		$app            = JFactory::getApplication();
		$params         = $app->getParams();
		$dispatcher = JDispatcher::getInstance();

		// Get some data from the models
		$this->user = VELOdb::getCurrentUser();
		$state          = $this->get('State');
		//$id		= intval(JRequest::getVar('id', 0, 'get', 'int'));
		$item   = $this->get('Item');
		$form   = $this->get('Form');
		$this->zoomLevels = $this->get('ZoomLevels');
		$composants = $this->get('Composants');
		//$this->tarifs	= $this->get('Tarifs');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
        $this->form = $form;
		$this->item = $item;
		$this->state = $state;
		//$this->item->velo_id = JRequest::getVar('velo_id', '0', 'get', 'int');
		$this->composants = $composants;
		$this->params	= $this->state->get('params');

		// add some styles
		$doc = JFactory::getDocument();
		$doc->addStyleSheet('components/com_velo/css/admin.css');
		$doc->addStyleSheet('components/com_velo/css/com_velo.css');
		$doc->addStyleSheet('components/com_velo/css/layout.css');
		// add com scripts
		$doc->addScript('administrator/components/com_velo/js/ajax.js');

		// add breadcrumbs
		$app    = JFactory::getApplication();
		$pathway = $app->getPathway();
		if (!isset($this->item->id) || $this->item->id == 0) {
			$pathway->addItem(JText::_('COM_VELO_ADD_VELO'), 'index.php?option='.JRequest::getVar('option', '0', 'get', 'string').'&view='.$this->getName().'&layout='.$this->getLayout().'&Itemid='.JRequest::getVar('Itemid', 0, 'get','int'));
		} else {
			$pathway->addItem($this->item->label, 'index.php?option='.JRequest::getVar('option', '0', 'get', 'string').'&view='.$this->getName().'&layout='.$this->getLayout().'&id=0&Itemid='.JRequest::getVar('Itemid', 0, 'get','int'));
		}

		// Display the view
		parent::display($tpl);
	}
}