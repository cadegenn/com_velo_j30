<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
 
/**
 * HTML View class for the chantiers Component
 */
class veloViewMonStock extends JView
{
	// Overwriting JView display method

	function display($tpl = null) 
	{
		// Assign data to the view
		//$this->msg = $this->get('Msg');
		$this->user = VELOdb::getCurrentUser();
		if ($this->user->id != 0) {
			$this->stock = $this->get('Items');	// ==> /components/com_velo/models/monstock.php
			$this->wishlist = $this->get('WishList');	// ==> /components/com_velo/models/monstock.php
		}
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Load scripts
		$this->addScripts();
		
		// add some styles
		$doc = JFactory::getDocument();
		$doc->addStyleSheet('components/com_velo/css/admin.css');
		$doc->addStyleSheet('components/com_velo/css/com_velo.css');
		$doc->addStyleSheet('components/com_velo/css/layout.css');

		// Display the view
		parent::display($tpl);
	}

	/**
     * Add the scripts to the document.
     */
    protected function addScripts()
    {
        $doc = JFactory::getDocument();
        $doc->addScript('administrator/components/com_velo/js/fonctions.js');
    }
    
}

?>
