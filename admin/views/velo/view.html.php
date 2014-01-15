<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * velo View
 */
class veloViewVelo extends JView
{
	/**
	 * velos view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		//$items = $this->get('Items');
		//$model = $this->get('Model');
		//$pagination = $this->get('Pagination');
		$pending_marques = $this->get('PendingMarques');
		$pending_models = $this->get('PendingParts');
		$latest_velos = $this->get('LatestVelos');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->pending_marques = $pending_marques;
		$this->pending_models = $pending_models;
		$this->latest_velos = $latest_velos;
		//$this->pagination = $pagination;
 
		// Set the toolbar
		$this->addToolBar();
		
		$doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_velo/css/admin.css');
		
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		// voir d'autres boutons dans /administrator/includes/toolbar.php
		JToolBarHelper::title(JText::_('COM_VELO'), 'velo');
		//JToolBarHelper::addNewX('velo.add');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_velo');
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_VELO_ADMINISTRATION'));
	}
}

?>
