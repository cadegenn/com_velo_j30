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
 * Part Model
 */
class veloModelPart extends JModelForm
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
	public function getTable($type = 'part', $prefix = 'veloTable', $config = array()) 
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
		$form = $this->loadForm('com_velo.part', 'part' /* -> models/forms/part.xml */, array('control' => 'jform', 'load_data' => true));
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
		$data = JFactory::getApplication()->getUserState('com_velo.edit.part.data', array());
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
		$query->select('md.*')->from('#__velo_models AS md')->where('md.id = '.$id);
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
		$part = new stdClass();
		$part->id = $data['id'];
		$part->published = 0;
		$part->label = $data['label'];
		$part->photo = $data['photo'];
		$part->url = $data['url'];
		$part->release_date = $data['release_date'];
		$part->const_composant_id = $data['const_composant_id'];
		$part->marque_id = $data['marque_id'];
		$part->const_materiau_id = $data['const_materiau_id'];
		$part->specs = $data['specs'];
		$part->poids = $data['poids'];
		$part->commentaires = $data['commentaires'];

		if ($part->id > 0) {
			// update record into database
			$part->modified_by = $this->user->id;
			$part->modification_date = $date->toSql();
			$saved = $db->updateObject('#__velo_models', $part, 'id');
		} else {
			unset($part->id);
			// insert new record into database
			$part->created_by = $this->user->id;
			$part->creation_date = $date->toSql();
			$saved = $db->insertObject('#__velo_models', $part);
		}
		
		return $saved;
	}
	
}
