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
 * MonVelo Model
 */
class veloModelMonVelo extends JModelForm
{
	/**
	 * @var object item
	 */
	protected $item;
	protected $context;

	public function __construct($config = array()) {
		$this->context = JRequest::getVar('option', '0', 'get', 'string');
		parent::__construct($config);
	}
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	composant	The table composant to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	2.5
	 */
	public function getTable($type = 'monVelo', $prefix = 'veloTable', $config = array()) 
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
		$form = $this->loadForm('com_velo.monvelo', 'velo' /* -> models/forms/velo.xml */, array('control' => 'jform', 'load_data' => true));
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
		$data = JFactory::getApplication()->getUserState('com_velo.edit.monvelo.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	0.0.13
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = JRequest::getInt('id');
		$this->setState('monvelo.id', $pk);

		$offset = JRequest::getUInt('limitstart');
		$this->setState('list.offset', $offset);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		// TODO: Tune these values based on other permissions.
		$user		= JFactory::getUser();
		if ((!$user->authorise('core.edit.state', 'com_velo')) &&  (!$user->authorise('core.edit', 'com_velo'))){
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}

		$zoomLevel = $app->getUserStateFromRequest($this->context.'.filter.zoomLevel', 'filter_zoomLevel');
		$this->setState('filter.zoomLevel', $zoomLevel);

	}

	/**
	 * @brief	getItem():	Method to get an item from database
	 * @param	
	 * @return	array	item
	 */
	public function getItem() {
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		if ($id == 0) { return false; }
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('v.*')->from('#__velo_monVelo AS v')->where('v.id = '.$id);
		$query->select('ct.label_tr AS ct_label')->from('#__velo_const_types AS ct')->where('ct.id = v.type_id');
		$query->select('mc.model_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.specs, mc.photos, mc.commentaires, mc.created_by, mc.creation_date');
		$query->from('#__velo_monComposant AS mc')->where('mc.id = v.composant_id');
		$query->select('md.marque_id, md.label AS model, md.url, md.photo')->from('#__velo_models AS md')->where('md.id = mc.model_id');
		$query->select('mq.label AS marque, mq.url AS marque_url')->from('#__velo_marques AS mq')->where('mq.id = md.marque_id');
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObject();
	}
	
	public function getComposants() {
		$id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$zoomLevel = JRequest::getVar('zoomLevel', 5, 'post', 'int');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.velo_id = '.$id);
		$query->select('md.marque_id, md.label AS model, md.poids, md.specs, md.photo, md.url')->from('#__velo_models AS md')->where('md.id = mc.model_id');
		$query->select('mq.label AS marque, mq.url AS marque_url')->from('#__velo_marques AS mq')->where('mq.id = md.marque_id');
		$query->select('cm.label_id AS cm_class, cm.label_tr AS materiau')->from('#__velo_const_materiaux AS cm')->where('cm.id = md.const_materiau_id');
		$query->select('cc.label_id AS class, cc.label_tr AS label, cc.zoomLevel')->from('#__velo_const_composants AS cc')->where('cc.id = md.const_composant_id');
		/*
		 * APPLY FILTERS
		 */
		// Filter by zoomLevel
		$zoomLevel = $this->getState('filter.zoomLevel');
		if (is_numeric($zoomLevel)) {
			$query->where('cc.zoomLevel <= '.$zoomLevel);
		}
		
		$query->order('cc.zoomLevel');
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObjectList();
	}
	
	public function getZoomLevels() {
		$zoomLevels = array();
		for ($i = 0; $i <= 4; $i++) {
			$zoomLevels[$i] = new stdClass();
			$zoomLevels[$i]->value = $i;
			$zoomLevels[$i]->text = JText::_('COM_VELO_ZOOMLEVEL_'.$i.'_LABEL');
		}
		
		return $zoomLevels;
	}

	/**
	 * 
	 * @param type $data
	 * 
	 * @TODO: merger ajouter() et modifier()
	 * 
	 */
	public function save($data) {
		if ($data['id'] == 0) {
			$saved        = $this->ajouter($data);		// -> models/monvelo.php: ajouter()
		} else {
			$saved        = $this->modifier($data);	// -> models/monvelo.php: modifier()
		}
		return $saved;
	}
	
	/**
	 * @brief	add a bike into database
	 * @param	array	$data
	 * @return	bool	$saved
	 * 
	 * @since	0.0.06
	 */
	public function ajouter($data) {
		// set the variables from the passed data
		//echo("<pre>"); var_dump($data); echo("</pre>");
		//$id = (isset($data['id']) ? $data['id'] : 0);

		$this->user = VELOdb::getCurrentUser();
		$date   = JFactory::getDate();
		$db = $this->getDbo();
		
		// properly build object
		$composant = new stdClass();
		$composant->created_by = $this->user->id;
		$composant->creation_date = $date->toSql();
		$composant->model_id = $data['model_id'];
		$composant->velo_id = 0;	// means THIS composant IS a bike
		$composant->date_achat = JFactory::getDate($data['date_achat'])->toSql();
		$composant->prix_achat = $data['prix_achat'];
		$composant->distance_achat = $data['distance_achat'];
		$composant->published = $data['published'];
		$composant->specs = $data['specs'];
		$composant->commentaires = $data['commentaires'];
		// insert new record into database
		$saved = $db->insertObject('#__velo_monComposant', $composant);
		
		if ($saved) {
			$composant->id = $db->insertid();
		
			// properly build velo ovject
			$velo = new stdClass();
			$velo->composant_id = $composant->id;
			$velo->type_id = $data['type_id'];
			$velo->label = $data['label'];
			$velo->owner = $data['owner'];
			$velo->bicycode = $data['bicycode'];
			// insert new record into database
			$saved = $db->insertObject('#__velo_monVelo', $velo);
		}
		
		return $saved;
	}
	
	/**
	 * @brief	update a bike into database
	 * @param	array	$data
	 * @return	bool	$saved
	 * 
	 * @since	0.0.06
	 */
	public function modifier($data) {
		// set the variables from the passed data
		//echo("<pre>"); var_dump($data); echo("</pre>");
		//$id = (isset($data['id']) ? $data['id'] : 0);

		$this->user = VELOdb::getCurrentUser();
		$date   = JFactory::getDate();
		$db = $this->getDbo();
		//$velo_id = intval(JRequest::getVar('id', 0, 'get', 'int'));
		$velo_id = $data['id'];
		
		if ($velo_id == 0) return false;
		
		// properly build object
		$composant = new stdClass();
		$composant->id = $data['composant_id'];
		$composant->modified_by = $this->user->id;
		$composant->modification_date = $date->toSql();
		$composant->model_id = $data['model_id'];
		$composant->velo_id = 0;	// means THIS composant IS a bike
		$composant->date_achat = JFactory::getDate($data['date_achat'])->toSql();
		$composant->prix_achat = $data['prix_achat'];
		$composant->distance_achat = $data['distance_achat'];
		$composant->published = $data['published'];
		$composant->specs = $data['specs'];
		$composant->commentaires = $data['commentaires'];
		// update record into database
		$saved = $db->updateObject('#__velo_monComposant', $composant, 'id');
		
		if ($saved) {
			// properly build velo object
			$velo = new stdClass();
			$velo->id = $velo_id;
			$velo->composant_id = $data['composant_id'];
			$velo->type_id = $data['type_id'];
			$velo->label = $data['label'];
			$velo->owner = $data['owner'];
			$velo->bicycode = $data['bicycode'];
			// update record into database
			$saved = $db->updateObject('#__velo_monVelo', $velo, 'id');
		}
		
		return $saved;
	}
	
	/**
	 * @brief	delete a bike
	 * @param	int		$id
	 * @return	bool	$deleted
	 * 
	 * @since	0.0.06
	 */
	public function supprimer($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// we only got velo's id, but we also need composant's id
		$query->select('*')->from('#__velo_monVelo')->where('id = '.$id);
		// Reset the query using our newly populated query object.
		$db->setQuery($query, 0, 1);
		$db->query();
		// Load the results as a list of stdClass objects.
		$monVelo = $db->loadObject();
		
		// now we can delete monComposant and monVelo
		$query = $db->getQuery(true);
		$query->delete('#__velo_monComposant')->where('id = '.$monVelo->composant_id);
		$db->setQuery($query);
		$result = $db->query();
		if (!$result) return false;
		$query = $db->getQuery(true);
		$query->delete('#__velo_monVelo')->where('id = '.$id);
		$db->setQuery($query);
		$db->query();
		if (!$result) return false;
		
		return $result;
	}
}
