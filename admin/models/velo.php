<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * velo Model
 */
class veloModelVelo extends JModel
{
	
	public function getPendingParts() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('md.*')->from('#__velo_models AS md')->where('md.published = 0')->order('md.creation_date DESC');
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}

	public function getPendingMarques() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('mq.*')->from('#__velo_marques AS mq')->where('mq.published = 0')->order('mq.creation_date DESC');
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}
	
	public function getLatestVelos() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('mv.*')->from('#__velo_monVelo AS mv');
		$query->select('mc.id AS mc_id, mc.created_by, mc.creation_date, mc.modified_by, mc.modification_date, mc.model_id, mc.velo_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.photos, mc.commentaires AS mc_commentaires');
		//$query->from('#__velo_monComposant AS mc')->where('mv.composant_id = mc.id');
		$query->leftjoin('#__velo_monComposant AS mc ON (mv.composant_id = mc.id)');
		//$query->select('mo.id AS mo_id, mo.marque_id')->from('#__velo_models AS mo')->where('mc.model_id = mo.id');
		$query->select('mo.id AS mo_id, mo.marque_id')->leftjoin('#__velo_models AS mo ON (mc.model_id = mo.id)');
		$query->order('mc.creation_date DESC');
		$db->setQuery($query, 0, 10);
		
		return $db->loadObjectList();
	}
}
