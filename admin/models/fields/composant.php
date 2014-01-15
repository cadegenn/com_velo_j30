<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Custom Field class for the Joomla Framework.
 *
 * @package             Joomla.Administrator
 * @subpackage          com_adh
 * @since               0.0.11
 */
class JFormFieldComposant extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       0.0.11
	 */
	protected $type = 'constcomposant';

	/**
	 * Method to get the field options.
	 *
	 * @return      array   The field option objects.
	 * @since       1.6
	 */	
	public function getOptions()
	{
		// Initialize variables.
		$options = array();
		$lang = JFactory::getLanguage();

		$db = JFactory::getDbo();
		$query  = $db->getQuery(true);

		//$query->select('id AS value, label AS text'); // => important !! AS value pour l'id et AS text pour le texte de l'option
		$query->select('m.id as value, m.label_tr as text');
		$query->from('#__velo_const_composants as m');
		$query->where('m.language = "'.$lang->getTag().'"');	// $lang = JFactory::getLanguage();
		$query->order('LOWER (label_tr)');

		/*
		 * APPLY FILTERS
		 */
		// Filter by author
		$user = VELOdb::getCurrentUser();
		if (is_numeric($user->id)) {
			$query->where('((published = 1) OR (published = 0 AND created_by = '.(int) $user->id.'))');
		} else {
			$query->where('published = 1'); //->where('categorie = "'.$categorie.'"');
		}
		// if we got a filter, use it
		if ($this->element['zoomLevel']) {
			$query->where('m.zoomLevel IN ('.$this->element['zoomLevel'].')');
		}
				
		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
						JError::raiseWarning(500, $db->getErrorMsg());
		}

		return array('*' => JText::_('JOPTION_SELECT_COMPOSANT')) + $options;
		//return $options;
	}

	protected function getInput() {
		$uri	= JFactory::getURI();
		$return = base64_encode($uri);
		$html[] = parent::getInput();
		
		if ((string) $this->element['button_add'] == 'true') {
			$html[] = "<a href='index.php?option=".JRequest::getVar('option', '0', 'get', 'string')."&view=".$this->type."&layout=edit&return=".$return."'><img src='components/".JRequest::getVar('option', '0', 'get', 'string')."/images/ico-16x16/add.png' alt='".JText::_('COM_VELO_PROPOSE_COMPOSANT')."' /></a>";
		}
		
		return implode($html);
	}
}