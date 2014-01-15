<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');

JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
 
/**
 * velo Component Controller
 */
class veloController extends JController
{
	
	/**
	 * @brief	function to retrieve Parts (#__velo_models) by AJAX
	 */
	public function getParts() {
		$const_composant_id = intval(JRequest::getVar('const_composant_id', 0, 'post', 'int'));
		$marque_id = intval(JRequest::getVar('marque_id', 0, 'post', 'int'));
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$user = VELOdb::getCurrentUser();
		
		$query->select('mo.id as value, CONCAT_WS(" - ",ma.label,YEAR(mo.release_date),mo.label) as text');
		$query->from('#__velo_models AS mo');
		$query->leftjoin('#__velo_marques AS ma ON (ma.id = mo.marque_id)');
		if ($marque_id > 0) { $query->where('mo.marque_id = '.$marque_id); }
		if ($const_composant_id > 0) { $query->where('mo.const_composant_id = '.$const_composant_id); }
		if (is_numeric($user->id)) {
			$query->where('(mo.published = 1 OR (mo.published = 0 AND mo.created_by = '.(int) $user->id.'))');
		} else {
			$query->where('mo.published = 1');
		}
		$query->order('LOWER (ma.label), YEAR(mo.release_date) ASC, LOWER (mo.label)');
		
		$db->setQuery($query);
		$db->query();
		$parts = $db->loadAssocList();

		
		echo json_encode($parts);
	}
}

?>
