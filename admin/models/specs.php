
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * veloModelSpecs List Model
 */
class veloModelSpecs extends JModelList
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
				'label_id', 'm.label_id', 'label_tr', 'm.label_tr',
				'zoomLevel', 'm.zoomLevel',
				'created_by', 'm.created_by', 'author_name',
				'creation_date', 'm.creation_date',
				'url', 'm.url',
				'published', 'm.published',
				'language', 'language_title',
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
		// Select some fields
		$query->select('m.*, l.title as language_title');
		$query->from('#__velo_const_specs as m');
		$query->leftjoin('#__languages as l ON (m.language = l.lang_code)');
		
		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = m.created_by');
				
		/*
		 * APPLY FILTERS
		 */
		// filter.lang = '' => filter on connected user's language (or default)
		// filter.lang = '*' => no filter : display all languages
		// filter.lang = '##-##' => filter on this language
		$filter_lang = $this->getState('filter.language');
		if (!empty($filter_lang)) {
			if ($filter_lang != '*') { $query->where('m.language = "'.$filter_lang.'"'); }
		} else {
			// vu sur http://stackoverflow.com/questions/3352241/how-to-detect-the-current-language-of-a-joomla-website
			$lang = JFactory::getLanguage();
			$query->where('m.language = "'.$lang->getTag().'"');
		}
		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_numeric($authorId)) {
			$query->where('m.created_by = '.(int) $authorId);
		}
		
		//$query->order('catid');
		//$query->order('pays');
		//$query->order('label_id, label_tr');
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'LOWER(m.label)');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));

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

		// Load the filter state.
		$filter_lang = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language');
		$this->setState('filter.language', $filter_lang);

		$authorId = $app->getUserStateFromRequest($this->context.'.filter.author_id', 'filter_author_id');
		$this->setState('filter.author_id', $authorId);

		// List state information.
		parent::populateState('m.label_id', 'asc');
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
		$query->join('INNER', '#__velo_const_specs AS c ON c.created_by = u.id');
		$query->group('u.id, u.name');
		$query->order('u.name');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

}
?>
