
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * veloModelVelos List Model
 */
class veloModelMesVelos extends JModelList
{
    /**
     * Method to build an SQL query to load the list data.
     *
     * @return	string	An SQL query
     */
    protected function getListQuery() {
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('mv.*, mv.id AS monVeloId');
		$query->from('#__velo_monVelo as mv');
		// Join over the type
		$query->select('ct.label_tr AS type');
		$query->join('LEFT', '#__velo_const_types AS ct ON ct.id = mv.type_id');
		// Join over the monComposant
		$query->select('mc.created_by, mc.creation_date, mc.modified_by, mc.modification_date, mc.model_id, mc.velo_id, mc.date_achat, mc.prix_achat, mc.distance_achat, mc.date_vente, mc.prix_vente, mc.distance_vente, mc.published, mc.photos, mc.commentaires AS mc_commentaires');
		$query->join('LEFT', '#__velo_monComposant AS mc ON mc.id = mv.composant_id');
		// Join over the models (parts)
		$query->select('md.label AS model, md.marque_id, md.const_materiau_id, md.photo');
		$query->join('LEFT', '#__velo_models AS md ON md.id = mc.model_id');

		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = mc.created_by');
		
		// Join over the marque
		$query->select('ma.label AS marque, ma.url AS marque_url');
		$query->join('LEFT', '#__velo_marques AS ma ON ma.id = md.marque_id');
		// Join over the materiau
		$query->select('c_ma.label_tr AS materiau');
		$query->join('LEFT', '#__velo_const_materiaux AS c_ma ON c_ma.id = md.const_materiau_id');
				
		/*
		 * APPLY FILTERS
		 */
		// Filter by type
		$typeId = $this->getState('filter.type_id');
		if (is_numeric($typeId)) {
			$query->where('mv.type_id = '.(int) $typeId);
		}
		// Filter by marque
		$marqueId = $this->getState('filter.marque_id');
		if (is_numeric($marqueId)) {
			$query->where('md.marque_id = '.(int) $marqueId);
		}
		// Filter by materiau
		$materiauId = $this->getState('filter.materiau_id');
		if (is_numeric($materiauId)) {
			$query->where('md.const_materiau_id = '.(int) $materiauId);
		}
		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_numeric($authorId)) {
			$query->where('mc.created_by = '.(int) $authorId);
		}
		
		//$query->order('catid');
		//$query->order('pays');
		$query->order('LOWER(marque), LOWER(mv.label)');

		return $query;
    }

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since		1.6
	 * @see			http://docs.joomla.org/How_to_add_custom_filters_to_component_admin
	*/
	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		$typeId = $app->getUserStateFromRequest($this->context.'.filter.type_id', 'filter_type_id');
		$this->setState('filter.type_id', $typeId);

		$marqueId = $app->getUserStateFromRequest($this->context.'.filter.marque_id', 'filter_marque_id');
		$this->setState('filter.marque_id', $marqueId);

		$materiauId = $app->getUserStateFromRequest($this->context.'.filter.materiau_id', 'filter_materiau_id');
		$this->setState('filter.materiau_id', $materiauId);

		$authorId = $app->getUserStateFromRequest($this->context.'.filter.author_id', 'filter_author_id');
		$this->setState('filter.author_id', $authorId);

		// List state information.
		parent::populateState('#__velo_models.label', 'asc');
	}
	
	/**
	 * Build a list of authors
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getAuthors() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('u.id AS value, u.name AS text');
		$query->from('#__users AS u');
		$query->join('INNER', '#__velo_models AS c ON c.created_by = u.id');
		$query->group('u.id, u.name');
		$query->order('u.name');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

	/**
	 * Build a list of marques
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getMarques() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('ma.id AS value, ma.label AS text');
		$query->from('#__velo_marques AS ma');
		$query->join('INNER', '#__velo_models AS md ON (md.marque_id = ma.id)');		// const_composant_id = 0 => type vélo
		$query->join('INNER', '#__velo_const_composants AS cc ON (md.const_composant_id = cc.id AND cc.label_id = "bike")');
		$query->group('ma.id, ma.label');
		$query->order('LOWER(ma.label)');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

	/**
	 * Build a list of materiaux
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getMateriaux() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('cm.id AS value, cm.label_tr AS text');
		$query->from('#__velo_const_materiaux AS cm');
		$query->join('INNER', '#__velo_models AS md ON (md.const_materiau_id = cm.id)');
		$query->join('INNER', '#__velo_const_composants AS cc ON (md.const_composant_id = cc.id AND cc.label_id = "bike")');
		$query->group('cm.id, cm.label_tr');
		$query->order('LOWER(cm.label_tr)');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

	/**
	 * Build a list of materiaux
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getTypes() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('ct.id AS value, ct.label_tr AS text');
		$query->from('#__velo_const_types AS ct');
		$query->join('INNER', '#__velo_monVelo AS mv ON mv.type_id = ct.id');
		$query->group('ct.id, ct.label_tr');
		$query->order('LOWER(ct.label_tr)');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

}
?>
