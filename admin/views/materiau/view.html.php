<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * materiau View
 * 
 */
class veloViewMateriau extends JView
{
    /**
     * display method of Hello view
     * @return void
     */
    public function display($tpl = null) 
    {
        // get the Data
        $form = $this->get('Form');
        $item = $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
                JError::raiseError(500, implode('<br />', $errors));
                return false;
        }
        // Assign the Data
        $this->form = $form;
        $this->item = $item;

        // Set the toolbar
        $this->addToolBar();
        // Load styleSheet
        $this->addDocStyle();
        // Load scripts
        $this->addScripts();

        // Ajouter le sous menu
        veloHelper::addSubmenu('materiaux');	// => admin/helpers/velo.php

        // Display the template
        parent::display($tpl);		// -> ./tmpl/edit.php
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar() 
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);
        $isNew = ($this->item->id == 0);
		
        JToolBarHelper::title($isNew ? JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_MATERIAU_NEW')
                                     : JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_MATERIAU_EDIT'));
		JToolBarHelper::apply('materiau.apply');
        JToolBarHelper::save('materiau.save');                                      // --> administrator/components/com_velo/controllers/materiau.php::save();
		JToolBarHelper::save2new('materiau.save2new');
        JToolBarHelper::cancel('materiau.cancel', $isNew    ? 'JTOOLBAR_CANCEL'      // --> administrator/components/com_velo/controllers/materiau.php::cancel();
															: 'JTOOLBAR_CLOSE');
    }

    /**
     * Add the stylesheet to the document.
     */
    protected function addDocStyle()
    {
        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_velo/css/admin.css');
    }
    
    /**
     * Add the scripts to the document.
     */
    protected function addScripts()
    {
        $doc = JFactory::getDocument();
        $doc->addScript('components/com_velo/js/fonctions.js');
    }
    
}
