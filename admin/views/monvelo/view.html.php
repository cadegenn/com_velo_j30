<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * model View
 * 
 */
class veloViewMonVelo extends JView
{
    /**
     * display method of Hello view
     * @return void
     */
	
	/*
	 * $option	(string)	name of component
	 */
	public $option;
	
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->option = JRequest::getVar('option', '0', 'get', 'string');
	}
	
    public function display($tpl = null) 
    {
        // get the Data
        $form = $this->get('Form');
        $item = $this->get('Item');
		$composant = $this->get('Composant');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
                JError::raiseError(500, implode('<br />', $errors));
                return false;
        }
        // Assign the Data
        $this->form = $form;
        $this->item = $item;
		$this->composant = $composant;

        // Set the toolbar
        $this->addToolBar();
        // Load styleSheet
        $this->addDocStyle();
        // Load scripts
        $this->addScripts();

        // Ajouter le sous menu
        veloHelper::addSubmenu('velos');	// => admin/helpers/velo.php

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
		
        JToolBarHelper::title($isNew ? JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_VELO_NEW')
                                     : JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_VELO_EDIT'));
		JToolBarHelper::apply('monvelo.apply');
        JToolBarHelper::save('monvelo.save');                                      // --> administrator/components/com_velo/controllers/model.php::save();
		JToolBarHelper::save2new('monvelo.save2new');
        JToolBarHelper::cancel('monvelo.cancel', $isNew    ? 'JTOOLBAR_CANCEL'      // --> administrator/components/com_velo/controllers/model.php::cancel();
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
