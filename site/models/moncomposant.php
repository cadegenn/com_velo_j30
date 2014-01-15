<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted amcess');
 
// Include dependancy of the main model form
jimport('joomla.application.component.modelform');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');

JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

/**
 * MonComposant Model
 */
class veloModelMonComposant extends JModelForm
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
	public function getTable($type = 'monComposant', $prefix = 'veloTable', $config = array()) 
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
		$form = $this->loadForm('com_velo.moncomposant', 'moncomposant' /* -> models/forms/moncomposant.xml */, array('control' => 'jform', 'load_data' => true));
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
		$data = JFactory::getApplication()->getUserState('com_velo.edit.moncomposant.data', array());
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
		if ($id == 0) {
			// we create a new component to associate with a bike. Let's return at least the bike's id so it is pre-selected in the drop-down list
			$obj = new stdClass();
			$obj->velo_id = intval(JRequest::getVar('velo_id', 0, 'get', 'int'));
			return $obj;
		}
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		//$query->select('v.label ')->from('#__velo_monVelo AS v')->where('v.id = '.$id);
		//$query->select('mc.model_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.photos, mc.commentaires');
		$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.id = '.$id);
		$query->select('mv.label AS velo')->leftjoin('#__velo_monVelo AS mv ON (mc.velo_id = mv.id)');
		//$query->select('md.label AS label, md.url, md.release_date, md.specs, md.poids, md.const_materiau_id, md.marque_id, md.const_composant_id')->from('#__velo_models AS md')->where('md.id = mc.model_id');
		$query->select('md.label AS label, md.url, md.release_date, md.specs, md.poids, md.const_materiau_id, md.marque_id, md.const_composant_id')->leftjoin('#__velo_models AS md ON (md.id = mc.model_id)');
		$query->select('mq.label AS marque, mq.url AS marque_url')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');
		$query->select('mx.label_tr AS materiau')->leftjoin('#__velo_const_materiaux AS mx ON (mx.id = md.const_materiau_id)');
		//$query->from('#__velo_marques AS mq')->where('mq.id = md.marque_id');
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObject();
	}

	/**
	 * @brief	get items of the model_id requested in _GET array. //Only fetch items not attached to a bike
	 *			only fetch items with same published policy as as the model_id
	 * @return boolean
	 */
	public function getItems() {
		$model_id = intval(JRequest::getVar('model_id', 0, 'get', 'int'));
		$published = intval(JRequest::getVar('published', 0, 'get', 'int'));
		if ($model_id == 0) { return false; }
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.model_id = '.$model_id)->where('mc.velo_id = 0');
		$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.model_id = '.(int) $model_id)->where('mc.published = '.(int) $published);
		$query->select('mv.label AS velo')->leftjoin('#__velo_monVelo AS mv ON (mc.velo_id = mv.id)');
		$query->select('md.id AS model_id, md.label AS label')->leftjoin('#__velo_models AS md ON (mc.model_id = md.id)');
		$query->select('mq.label AS marque')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');
		$query->select('cc.label_id AS class, cc.label_tr AS composant, cc.zoomLevel')->leftjoin('#__velo_const_composants AS cc ON (cc.id = md.const_composant_id)');
		$query->where('cc.zoomLevel > 0');
		$query->order('cc.zoomLevel ASC');
		$db->setQuery($query->__toString());
		
		return $db->loadObjectList();
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
		$monComposant = new stdClass();
		$monComposant->id = $data['id'];
		$monComposant->model_id = $data['model_id'];
		$monComposant->velo_id = $data['velo_id'];
		$monComposant->date_achat = $data['date_achat'];
		$monComposant->prix_achat = $data['prix_achat'];
		$monComposant->distance_achat = $data['distance_achat'];
		$monComposant->date_vente = $data['date_vente'];
		$monComposant->prix_vente = $data['prix_vente'];
		$monComposant->distance_vente = $data['distance_vente'];
		$monComposant->published = $data['published'];
		$monComposant->commentaires = $data['commentaires'];

		if ($monComposant->id > 0) {
			// update record into database
			$monComposant->modified_by = $this->user->id;
			$monComposant->modification_date = $date->toSql();
			$saved = $db->updateObject('#__velo_monComposant', $monComposant, 'id');
		} else {
			// insert new record into database
			$monComposant->created_by = $this->user->id;
			$monComposant->creation_date = $date->toSql();
			$saved = $db->insertObject('#__velo_monComposant', $monComposant);
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
		
		// now we can delete monComposant
		$query = $db->getQuery(true);
		$query->delete('#__velo_monComposant')->where('id = '.$id);
		$db->setQuery($query);
		return $db->query();
	}
	
	/**
	 * @brief	attach a component
	 * @param	int		$id
	 * @return	bool	$attached
	 * 
	 * @since	0.0.06
	 */
	public function attacher($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
        $this->user = VELOdb::getCurrentUser();
        $date   = JFactory::getDate();
        
        $db->setQuery('SELECT * FROM #__velo_monComposant WHERE id = '.$id)->execute();
        $composant = $db->loadObject();
        $db->setQuery('SELECT * FROM #__velo_monVelo WHERE id = '.$composant->velo_id)->execute();
        $velo = $db->loadObject();

        // add an entry in the "maintenance" table
        $maMaintenance = new stdClass();
        $maMaintenance->created_by = $this->user->id;
        $maMaintenance->creation_date = $date->toSql();
        $maMaintenance->temps = 0;
        $maMaintenance->velo_id = $velo->id;
        $maMaintenance->composant_id = $id;
        $maMaintenance->distance = 0;
        $maMaintenance->description = JText::sprintf('COM_VELO_DB_ITEM_ATTACHED', $id, $velo->label);
        $db->insertObject('#__velo_maMaintenance', $maMaintenance);
        
        // update monComposant status
        $query = $db->getQuery(true);
		$query->update('#__velo_monComposant')->set('published = 1')->where('id = '.$id);
		$db->setQuery($query);
		return $db->query();
	}
	
	/**
	 * @brief	detach a component
	 * @param	int		$id
	 * @return	bool	$detached
	 * 
	 * @since	0.0.06
	 */
	public function detacher($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
		$db = JFactory::getDBO();
        $this->user = VELOdb::getCurrentUser();
        $date   = JFactory::getDate();
        
        $db->setQuery('SELECT * FROM #__velo_monComposant WHERE id = '.$id)->execute();
        $composant = $db->loadObject();
        $db->setQuery('SELECT * FROM #__velo_monVelo WHERE id = '.$composant->velo_id)->execute();
        $velo = $db->loadObject();

        // add an entry in the "maintenance" table
        $maMaintenance = new stdClass();
        $maMaintenance->created_by = $this->user->id;
        $maMaintenance->creation_date = $date->toSql();
        $maMaintenance->temps = 0;
        $maMaintenance->velo_id = $velo->id;
        $maMaintenance->composant_id = $id;
        $maMaintenance->distance = 0;
        $maMaintenance->description = JText::sprintf('COM_VELO_DB_ITEM_DETTACHED', $id, $velo->label);
        $db->insertObject('#__velo_maMaintenance', $maMaintenance);
        
        // update monComposant status
		$query = $db->getQuery(true);
		$query->update('#__velo_monComposant')->set('published = 0')->where('id = '.$id);
		$db->setQuery($query);
		return $db->query();
	}
	
	/**
	 * @brief	duplicate a component
	 * @param	int		$id
	 * @return	bool	$deleted
	 * 
	 * @since	0.0.19
	 */
	public function dupliquer($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// search for component and load it
		$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.id = '.$id);
		$db->setQuery($query);
		$composant = $db->loadObject();
		// delete component's id and insert it
		unset($composant->id);
		$saved = $db->insertObject('#__velo_monComposant', $composant);
		
		return $saved;
	}
	
	/**
	 * @brief	stock a component
	 * @param	int		$id
	 * @return	bool	$deleted
	 * 
	 * @since	0.0.19
	 */
	public function stocker($id = 0) {
		if ($id == 0) return false;
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->update('#__velo_monComposant')->set('published = 0')->set('velo_id = 0')->where('id = '.$id);
		$db->setQuery($query);
		return $db->query();
	}
	
}
