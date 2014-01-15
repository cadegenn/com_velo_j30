<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * velo View
 */
class veloViewSpecs extends JView {
    /**
     * velos view display method
     * @return void
     */
    function display($tpl = null)  {
        // Get data from the model
        $items = $this->get('Items');			// => admin/models/specs.php
        $pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Assign data to the view
        $this->items = $items;
        $this->pagination = $pagination;
        $this->state = $this->get('State');
        $this->authors = $this->get('Authors');

        // Set the toolbar
        $this->addToolBar();

        // Ajouter le sous menu
        veloHelper::addSubmenu('config');	// => admin/helpers/velo.php

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
        JToolBarHelper::title(JText::_('COM_VELO').' : '.JText::_('COM_VELO_SUBMENU_SPECS'), 'velo');
        JToolBarHelper::addNewX('spec.add');
        JToolBarHelper::editListX('spec.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('specs.publish');
        JToolBarHelper::unpublishList('specs.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::archiveList('specs.archive');
        JToolBarHelper::deleteListX(JText::_('COM_VELO_AREYOUSURE'), 'specs.delete');
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
