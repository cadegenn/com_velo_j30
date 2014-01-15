<?php
// No direct amcess to this file
defined('_JEXEC') or die('Restricted amcess');
 
// Include dependancy of the main model form
jimport('joomla.application.component.modelform');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');

JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

/**
 * Marque Model
 */
class veloModelMarque extends JModelForm
{
	/**
	 * @var object item
	 */
	protected $item;

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	composant	The table composant to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	2.5
	 */
	public function getTable($type = 'marque', $prefix = 'veloTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the data for a new qualification
	 */
	public function getForm($data = array(), $loadData = true)
	{

		$app = JFactory::getApplication('site');

		// Get the form.
		$form = $this->loadForm('com_velo.marque', 'marque' /* -> models/forms/marque.xml */, array('control' => 'jform', 'load_data' => true));
		if (empty($form)) {
			return false;
		}
		return $form;

	}
 
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	2.5
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_velo.edit.marque.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	/**
	 * @brief	getItem():	Method to get an item from database
	 * @param	
	 * @return	array	item
	 */
	public function getItem() {
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		//$velo_id = intval(JRequest::getVar('velo_id', 0, 'get', 'int'));
		if ($id == 0) return false;
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		//$query->select('v.label ')->from('#__velo_monVelo AS v')->where('v.id = '.$id);
		//$query->select('mc.model_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.photos, mc.commentaires');
		//$query->select('mc.*')->from('#__velo_marque AS mc')->where('mc.id = '.$id);
		//$query->select('md.marque_id, md.const_composant_id')->from('#__velo_models AS md')->where('md.id = mc.model_id');
		$query->select('mq.*')->from('#__velo_marques AS mq')->where('mq.id = '.$id);
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObject();
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState() {
		$return = JRequest::getVar('return', null, 'default', 'base64');
		$this->setState('return_page', base64_decode($return));
	}

	/**
	 * Get the return URL.
	 *
	 * @return	string	The return URL.
	 * @since	1.6
	 */
	public function getReturnPage() {
		return base64_encode($this->getState('return_page'));
	}

	/**
	 * @brief	save a component into database
	 * @param	array	$data
	 * @return	bool	$saved
	 * 
	 * @since	0.0.06
	 */
	public function save($data) {
		// set the variables from the passed data
		//echo("<pre>"); var_dump($data); echo("</pre>");
		//$id = (isset($data['id']) ? $data['id'] : 0);

		$this->user = VELOdb::getCurrentUser();
		$date   = JFactory::getDate();
		$db = $this->getDbo();
		
		// properly build object
		$marque = new stdClass();
		$marque->id = $data['id'];
		$marque->label = $data['label'];
		$marque->logo = $data['logo'];
		$marque->url = $data['url'];
		$marque->favicon = $data['favicon'];
		$marque->published = 0;

		if ($marque->id > 0) {
			// update record into database
			$marque->modified_by = $this->user->id;
			$marque->modification_date = $date->toSql();
			$saved = $db->updateObject('#__velo_marques', $marque, 'id');
		} else {
			unset($marque->id);
			// insert new record into database
			$marque->created_by = $this->user->id;
			$marque->creation_date = $date->toSql();
			$saved = $db->insertObject('#__velo_marques', $marque);
		}
		
		return $saved;
	}
	
	
	/**
	 * @brief	delete a component
	 * @param	int		$id
	 * @return	bool	$deleted
	 * 
	 * @since	0.0.06
	 */
	public function supprimer($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// now we can delete marque
		$query = $db->getQuery(true);
		$query->delete('#__velo_marque')->where('id = '.$id);
		$db->setQuery($query);
		return $db->query();
	}
}
