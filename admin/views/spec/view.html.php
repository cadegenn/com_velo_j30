<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * spec View
 * 
 */
class veloViewSpec extends JView
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
        veloHelper::addSubmenu('specs');	// => admin/helpers/velo.php

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
		
        JToolBarHelper::title($isNew ? JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_SPEC_NEW')
                                     : JText::_('COM_VELO').' : '.JText::_('COM_VELO_MANAGER_SPEC_EDIT'));
		JToolBarHelper::apply('spec.apply');
        JToolBarHelper::save('spec.save');                                      // --> administrator/components/com_velo/controllers/spec.php::save();
		JToolBarHelper::save2new('spec.save2new');
		JToolBarHelper::save2copy('spec.save2copy');
        JToolBarHelper::cancel('spec.cancel', $isNew    ? 'JTOOLBAR_CANCEL'      // --> administrator/components/com_velo/controllers/spec.php::cancel();
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
		JText::script('COM_VELO_ZOOMLEVEL_0_DESC');
		JText::script('COM_VELO_ZOOMLEVEL_1_DESC');
		JText::script('COM_VELO_ZOOMLEVEL_2_DESC');
		JText::script('COM_VELO_ZOOMLEVEL_3_DESC');
		JText::script('COM_VELO_ZOOMLEVEL_4_DESC');
		JText::script('COM_VELO_ZOOMLEVEL_5_DESC');
    }
    
}
