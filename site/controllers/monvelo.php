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
class veloControllerMonVelo extends JControllerForm
{
    function __construct($config = array()) {
		// le pluriel par défaut de Joomla n'est pas le bon : monvelo => mesvelos
		$this->view_list = 'mesvelos';
		parent::__construct($config);
    }
	
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param	string	$name	The model name. Optional.
	 * @param	string	$prefix	The class prefix. Optional.
	 * @param	array	$config	Configuration array for model. Optional.
	 *
	 * @return	object	The model.
	 *
	 * @since	1.5
	 */
	/*public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}*/

	public function save() {
		$result = parent::save();
		//echo("<pre>"); var_dump($this); echo("</pre>");
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_list
				. $this->getRedirectToListAppend(), false
			)
		);

		return $result;
	}
	
	public function enregistrer() {
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('monvelo');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		//echo("<pre>"); var_dump($data); echo("</pre>");
		
		// Now update the loaded data to the database via a function in the model
		if ($data['id'] == 0) {
			$saved        = $model->ajouter($data);		// -> models/monvelo.php: ajouter()
		} else {
			$saved        = $model->modifier($data);	// -> models/monvelo.php: modifier()
		}

		// check if ok and display appropriate message.  This can also have a redirect if desired.
		/*if ($saved) {
			echo "<h2>Ajout success</h2>";
		} else {
			echo "<h2>Ajout failed</h2>";
		}*/

		// Redirect to the list screen.
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_list
				. $this->getRedirectToListAppend(), false
			)
		);

		return true;
	}

	public function supprimer() {
		// Check for request forgeries.
		JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app    = JFactory::getApplication();
		$model  = $this->getModel('monvelo');
		
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$deleted = $model->supprimer($id);		// -> models/monvelo.php: supprimer()
		
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($deleted) {
			echo "<h2>Suppression success</h2>";
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($id)));
		} else {
			echo "<h2>Suppression failed</h2>";
			$this->setMessage($model->getError());
		}

		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
	}

}
