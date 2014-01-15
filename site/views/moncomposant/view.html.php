<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
 
/**
 * HTML View class for the MonComposant Component
 */
class veloViewMonComposant extends JView
{
	// Overwriting JView display method
	function display($tpl = null)  {
		$app            = JFactory::getApplication();
		$params         = $app->getParams();
		$dispatcher = JDispatcher::getInstance();

		// Get some data from the models
		$this->user = VELOdb::getCurrentUser();
		//$id		= intval(JRequest::getVar('id', 0, 'get', 'int'));
		$item   = $this->get('Item');	// get 1 item => the one requested by _GET var &id=
		$items	= $this->get('Items');	// get items of same model_id of the one requested
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
		$this->item = $item;
		$this->items = $items;
		$this->state = $state;
		//$this->state->set('authorId',$this->user);
		$this->return_page	= $this->get('ReturnPage');

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
			$pathway->addItem(JText::_('COM_VELO_NEW_COMPONENT'), 'index.php?option='.JRequest::getVar('option', '0', 'get', 'string').'&view='.$this->getName().'&layout=edit&id=0&Itemid='.JRequest::getVar('Itemid', 0, 'get','int'));
		} else {
			$pathway->addItem($this->item->label, 'index.php?option='.JRequest::getVar('option', '0', 'get', 'string').'&view='.$this->getName().'&layout=edit&id='.$this->item->id.'&Itemid='.JRequest::getVar('Itemid', 0, 'get','int'));
		}

// Display the view
		parent::display($tpl);
	}
}