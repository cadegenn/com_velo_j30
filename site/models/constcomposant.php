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
 * ConstComposant Model
 */
class veloModelConstComposant extends JModelForm
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
	public function getTable($type = 'constcomposant', $prefix = 'veloTable', $config = array()) 
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
		$form = $this->loadForm('com_velo.const_composant', 'const_composant' /* -> models/forms/const_composant.xml */, array('control' => 'jform', 'load_data' => true));
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
		$data = JFactory::getApplication()->getUserState('com_velo.edit.const_composant.data', array());
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
		//$query->select('mc.*')->from('#__velo_const_composant AS mc')->where('mc.id = '.$id);
		//$query->select('md.const_composant_id, md.const_composant_id')->from('#__velo_models AS md')->where('md.id = mc.model_id');
		$query->select('cc.*')->from('#__velo_const_composants AS cc')->where('cc.id = '.$id);
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObject();
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
		$const_composant = new stdClass();
		$const_composant->id = $data['id'];
		$const_composant->label_id = $data['label_id'];
		$const_composant->label_tr = $data['label_tr'];
		$const_composant->language = $data['language'];
		$const_composant->zoomLevel = $data['zoomLevel'];
		$const_composant->published = 0;

		if ($const_composant->id > 0) {
			// update record into database
			$const_composant->modified_by = $this->user->id;
			$const_composant->modification_date = $date->toSql();
			$saved = $db->updateObject('#__velo_const_composants', $const_composant, 'id');
		} else {
			unset($const_composant->id);
			// insert new record into database
			$const_composant->created_by = $this->user->id;
			$const_composant->creation_date = $date->toSql();
			$saved = $db->insertObject('#__velo_const_composants', $const_composant);
		}
		
		return $saved;
	}
	
}
