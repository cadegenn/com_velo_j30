<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * velo Model
 */
class veloModelMonVelo extends JModelAdmin
{
	/*public function __construct($config = array()) {
		$config['text_prefix'] = "com_velo";
		parent::__construct($config);
	}*/
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table model to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	2.5
	 */
	public function getTable($type = 'monvelo', $prefix = 'veloTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	2.5
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_velo.monvelo', 'monvelo' /* --> models/forms/velo.xml */,
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
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
	
	public function getItem($id = 0) {
		$id = JRequest::getVar('id', $id, 'get','int');
		if ($id == 0) return false;
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('mv.*')->from('#__velo_monVelo AS mv')->where('mv.id = '.$id);
		$query->select('mc.id AS mc_id, mc.created_by, mc.creation_date, mc.modified_by, mc.modification_date, mc.model_id, mc.velo_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.specs, mc.photos, mc.commentaires AS mc_commentaires');
		//$query->from('#__velo_monComposant AS mc')->where('mv.composant_id = mc.id');
		$query->leftjoin('#__velo_monComposant AS mc ON (mv.composant_id = mc.id)');
		//$query->select('mo.id AS mo_id, mo.marque_id')->from('#__velo_models AS mo')->where('mc.model_id = mo.id');
		$query->select('mo.id AS mo_id, mo.marque_id')->leftjoin('#__velo_models AS mo ON (mc.model_id = mo.id)');
		//$query->select('ma.id AS marque_id')->from('#__velo_marques AS ma')->where('mo.marque_id = ma.id');
		//echo("<pre>"); var_dump($query->__toString()); echo("</pre>");
		
		$db->setQuery($query);
		$db->execute();
		
		return $db->loadObject();
	}

	/**
	 * Get composant of the item
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getComposant() {
		$id = JRequest::getVar('id', 0, 'get','int');
		if ($id == 0) return false;

		$item = $this->getItem();
		//echo("<pre>"); var_dump($item); echo("</pre>"); die();
		
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('mc.*');
		$query->from('#__velo_monComposant AS mc');
		$query->where('mc.id = '.$item->composant_id);

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObject();
	}

	/**
	 * Surcharge de la méthode save
	 * essentiellement pour formater correctement les données
	 * avant injection dans MySQL
	 */
	/*public function save($data) {
		echo("<pre>".var_dump($data)."</pre>");
		$data->nom = htmlentities($data->nom, ENT_QUOTES, 'UTF-8');
		echo("<pre>".var_dump($data)."</pre>");
		die();
	}*/
	
	/**
	 * @brief	on doit surcharger la méthode "publish()" pour 2 raisons :
	 *		. la table #__velo_monVelo ne possède pas de colonne "published" -> c'est la table #__velo_monComposant qui la possède
	 *		. la table #__velo_monComposant possède une colonne "status" au lieu de "published"
	 * 
	 * @param type $cid
	 * @param type $value
	 */
	public function publish($cid, $value) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		foreach ($cid as $id) {
			$item = $this->getItem($id);
			$query->update('#__velo_monComposant')->set('published = '.$value)->where('id = '.$item->composant_id);
			$db->setQuery($query->__toString());
			$result = $db->execute();
			if (!$result) { return false; }
		}
		return $result;
	}
	
	public function save($data) {
		$db = $this->getDbo();
		$date   = JFactory::getDate();
		$item = $this->getItem();
		
		// first save this item as a bike
		parent::save($data);

		// next save this item as a component (a bike is a component as well)
		$monComposant = new stdClass();
		$monComposant->id = $item->composant_id;
		$monComposant->model_id = $data['model_id'];
		$monComposant->velo_id = 0; // velo_id = 0 tells that this IS a bike, not a component; //$data['id'];
		$monComposant->date_achat = $data['date_achat'];
		$monComposant->prix_achat = $data['prix_achat'];
		$monComposant->distance_achat = $data['distance_achat'];
		$monComposant->date_vente = $data['date_vente'];
		$monComposant->prix_vente = $data['prix_vente'];
		$monComposant->distance_vente = $data['distance_vente'];
		$monComposant->published = $data['published'];
		$monComposant->commentaires = $data['commentaires'];
		// update record into database
		$monComposant->created_by = $data['created_by'];
		$monComposant->creation_date = $date->toSql();
		$monComposant->modified_by = $data['created_by'];
		$monComposant->modification_date = $date->toSql();
		$saved = $db->updateObject('#__velo_monComposant', $monComposant, 'id');
		
		// then, if created_by has changed, we have to change as well created_by of all this bike's parts
		$query = $db->getQuery(true);
		$query->update('#__velo_monComposant AS mc')->set('mc.created_by = '.$data['created_by'])->where('mc.velo_id = '.$item->composant_id);
		$db->setQuery($query->__toString());
		$result = $db->execute();
		if (!$result) { return false; }
		
		return $saved;
	}
}
