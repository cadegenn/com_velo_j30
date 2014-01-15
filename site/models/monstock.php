
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class veloModelMonStock extends JModelList
{
	protected $monstock;
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	public function getListQuery() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//$query->select('mc.*, Count(*) AS total')->from('#__velo_monComposant AS mc')->where('velo_id = 0 AND published = 0');
		$query->select('mc.*, Count(*) AS total')->from('#__velo_monComposant AS mc')->where('mc.published = 0');
		$query->select('md.id AS model_id, md.label AS label')->leftjoin('#__velo_models AS md ON (mc.model_id = md.id)');
		$query->select('mq.label AS marque')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');
		$query->select('cc.label_id AS class, cc.label_tr AS composant, cc.zoomLevel')->leftjoin('#__velo_const_composants AS cc ON (cc.id = md.const_composant_id)');
		$query->where('cc.zoomLevel > 0');
		$query->group('mc.model_id');
		$query->order('cc.zoomLevel ASC');
		
		/*
		 * APPLY FILTERS
		 */
		// Filter by author
		$user = VELOdb::getCurrentUser();
		if (is_numeric($user->id)) {
			$query->where('mc.created_by = '.(int) $user->id);
		}
				
		return $query;
	}

	public function getWishList() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//$query->select('mc.*, Count(*) AS total')->from('#__velo_monComposant AS mc')->where('velo_id = 0 AND published = 2');
		$query->select('mc.*, Count(*) AS total')->from('#__velo_monComposant AS mc')->where('mc.published = 2');
		$query->select('md.id AS model_id, md.label AS label')->leftjoin('#__velo_models AS md ON (mc.model_id = md.id)');
		$query->select('mq.label AS marque')->leftjoin('#__velo_marques AS mq ON (mq.id = md.marque_id)');
		$query->select('cc.label_id AS class, cc.label_tr AS composant, cc.zoomLevel')->leftjoin('#__velo_const_composants AS cc ON (cc.id = md.const_composant_id)');
		$query->where('cc.zoomLevel > 0');
		/*
		 * APPLY FILTERS
		 */
		// Filter by author
		$user = VELOdb::getCurrentUser();
		if (is_numeric($user->id)) {
			$query->where('mc.created_by = '.(int) $user->id);
		}
				
		$query->group('mc.model_id');
		$query->order('cc.zoomLevel ASC');
		$db->setQuery($query);
		$db->query();
		
		return $db->loadObjectList();
	}
	
}
?>
