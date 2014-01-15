<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Site
 * @subpackage	com_velo
 */
class veloControllerMonComposant extends JControllerForm
{
    function __construct($config = array()) {
		// le pluriel par défaut de Joomla n'est pas le bon : moncomposant => mescomposants
		$this->view_list = 'monstock';
		parent::__construct($config);
    }
	
	/**
	 * Get the return URL.
	 *
	 * If a "return" variable has been passed in the request
	 *
	 * @return	string	The return URL.
	 * @since	1.6
	 */
	protected function getReturnPage()
	{
		$return = JRequest::getVar('return', null, 'default', 'base64');
		if (empty($return) || !JUri::isInternal(base64_decode($return))) {
			return JURI::base();
		}
		else {
			return base64_decode($return);
		}
	}

	public function save() {
		$result = parent::save();
		//echo("<pre>"); var_dump($this); echo("</pre>");
		// If ok, redirect to the return page.
		if ($result) {
			$this->setRedirect($this->getReturnPage());
		}

		return $result;
	}
	
	public function supprimer() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('moncomposant');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$deleted = $model->supprimer($id);		// -> models/moncomposant.php: supprimer()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($deleted) {
			echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($id)));
		} else {
			echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		if ($deleted) {
			$this->setRedirect($this->getReturnPage());
		}
	}

	public function attacher() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('moncomposant');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$detached = $model->attacher($id);		// -> models/moncomposant.php: attacher()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($attached) {
			//echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_ATTACHED', count($id)));
		} else {
			//echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		if ($detached) {
			$this->setRedirect($this->getReturnPage());
		}
	}

	public function detacher() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('moncomposant');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$detached = $model->detacher($id);		// -> models/moncomposant.php: detacher()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($detached) {
			//echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DETACHED', count($id)));
		} else {
			//echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		if ($detached) {
			$this->setRedirect($this->getReturnPage());
		}
	}

	public function dupliquer() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('moncomposant');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$duplicated = $model->dupliquer($id);		// -> models/moncomposant.php: supprimer()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($duplicated) {
			//echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DUPLICATED', count($id)));
		} else {
			//echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		if ($duplicated) {
			$this->setRedirect($this->getReturnPage());
		}
	}

	public function stocker() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('moncomposant');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$stocked = $model->stocker($id);		// -> models/moncomposant.php: supprimer()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($stocked) {
			//echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_STOCKED', count($id)));
		} else {
			//echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		if ($stocked) {
			$this->setRedirect($this->getReturnPage());
		}
	}

}
