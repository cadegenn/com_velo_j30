
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * veloModelParts List Model
 */
class veloModelParts extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'm.id',
				'label', 'm.label', 'LOWER(m.label)',
				'created_by', 'm.created_by', 'author_name',
				'creation_date', 'm.creation_date',
				'url', 'm.url',
				'published', 'm.published',
				'marque',
				'composant',
				'materiau',
			);
		}

		parent::__construct($config);
	}

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return	string	An SQL query
     */
    protected function getListQuery() {
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('m.*');
		$query->from('#__velo_models as m');
		
		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = m.created_by');
		
		// Join over the marque
		$query->select('ma.label AS marque, ma.url AS marque_url');
		$query->join('LEFT', '#__velo_marques AS ma ON ma.id = m.marque_id');
		// Join over the composant
		$query->select('c_co.label_tr AS composant');
		$query->join('LEFT', '#__velo_const_composants AS c_co ON c_co.id = m.const_composant_id');
		// Join over the materiau
		$query->select('c_ma.label_tr AS materiau');
		$query->join('LEFT', '#__velo_const_materiaux AS c_ma ON c_ma.id = m.const_materiau_id');
				
		/*
		 * APPLY FILTERS
		 */
		// Filter by marque
		$marqueId = $this->getState('filter.marque_id');
		if (is_numeric($marqueId)) {
			$query->where('m.marque_id = '.(int) $marqueId);
		}
		// Filter by composant
		$composantId = $this->getState('filter.composant_id');
		if (is_numeric($composantId)) {
			$query->where('m.const_composant_id = '.(int) $composantId);
		}
		// Filter by materiau
		$materiauId = $this->getState('filter.materiau_id');
		if (is_numeric($materiauId)) {
			$query->where('m.const_materiau_id = '.(int) $materiauId);
		}
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('m.published = ' . (int) $published);
		}
		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_numeric($authorId)) {
			$query->where('m.created_by = '.(int) $authorId);
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'LOWER(m.label)');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));
		//$query->order('catid');
		//$query->order('pays');
		//$query->order('label');

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

		$marqueId = $app->getUserStateFromRequest($this->context.'.filter.marque_id', 'filter_marque_id');
		$this->setState('filter.marque_id', $marqueId);

		$composantId = $app->getUserStateFromRequest($this->context.'.filter.composant_id', 'filter_composant_id');
		$this->setState('filter.composant_id', $composantId);

		$materiauId = $app->getUserStateFromRequest($this->context.'.filter.materiau_id', 'filter_materiau_id');
		$this->setState('filter.materiau_id', $materiauId);

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$authorId = $app->getUserStateFromRequest($this->context.'.filter.author_id', 'filter_author_id');
		$this->setState('filter.author_id', $authorId);

		// List state information.
		parent::populateState('LOWER(m.label)', 'asc');
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
		$query->select('m.id AS value, m.label AS text');
		$query->from('#__velo_marques AS m');
		$query->join('INNER', '#__velo_models AS c ON c.marque_id = m.id');
		$query->group('m.id, m.label');
		$query->order('LOWER(m.label)');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

	/**
	 * Build a list of composants
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	public function getComposants() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('c.id AS value, c.label_tr AS text');
		$query->from('#__velo_const_composants AS c');
		$query->join('INNER', '#__velo_models AS m ON m.const_composant_id = c.id');
		$query->group('c.id, c.label_tr');
		$query->order('LOWER(c.label_tr)');

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
		$query->select('c.id AS value, c.label_tr AS text');
		$query->from('#__velo_const_materiaux AS c');
		$query->join('INNER', '#__velo_models AS m ON m.const_materiau_id = c.id');
		$query->group('c.id, c.label_tr');
		$query->order('LOWER(c.label_tr)');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

}
?>
