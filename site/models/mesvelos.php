
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class veloModelMesVelos extends JModelList
{
	protected $mesvelos;
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// on récupère l'id de la catégorie à afficher
		// l'id est disponible dans le tableau $_GET : voici la méthode joomla pour y accéder
		//$catid = JRequest::getVar('id', 0, 'get','int');
		
		//echo("<pre>"); var_dump($id); echo ("</pre>"); die();
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		//$query->select('#__velo_chantiers.*');
		$query->select('v.*')->from('#__velo_monVelo AS v');
		//$query->leftjoin('#__velo_const_types AS ct ON (ct.id = v.type_id)');
		$query->select('ct.label_tr')->from('#__velo_const_types AS ct')->where('ct.id = v.type_id');
		$query->select('mc.created_by, mc.creation_date, mc.modified_by, mc.modification_date, mc.published')->from('#__velo_monComposant AS mc')->where('mc.id = v.composant_id');
		$query->select('md.id AS model_id')->leftjoin('#__velo_models AS md ON (mc.model_id = md.id)');
		$query->select('mq.label AS marque, mq.url as marque_url')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');

		/*
		 * APPLY FILTERS
		 */
		// Filter by author
		$user = VELOdb::getCurrentUser();
		if (is_numeric($user->id)) {
			$query->where('mc.created_by = '.(int) $user->id);
		}
				

		//$query->where('owner = ');
		$query->order('ct.label_tr');
		$query->order('v.label');
		return $query;
	}
	
	public function getStock() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->select('mc.*')->from('#__velo_monComposant AS mc')->where('mc.published = 0 AND mc.velo_id = 0');
		$query->select('md.id AS model_id, md.label AS label')->leftjoin('#__velo_models AS md ON (mc.model_id = md.id)');
		$query->select('mq.label AS marque')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');
		$query->select('cc.label_id AS class, cc.label_tr AS composant, cc.zoomLevel')->leftjoin('#__velo_const_composants AS cc ON (cc.id = md.const_composant_id)');
		$query->where('cc.zoomLevel > 0');
		$query->order('cc.zoomLevel ASC');
		
		// Setup the query
		$db->setQuery($query->__toString());
		// Return the result
		return $db->loadObjectList();
	}
}
?>
