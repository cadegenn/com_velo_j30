<?php

/*
 * @desc	SPEC si a hidden input field containing json formatted pairs of keys and values
 * @display	It appears as a 
 * . dropdown list of predefined keys (defined on the view/spec(s) page)
 * . a visible input field to enter the value corresponding to the key
 * . an "add" button to add this pair to the hidden input field
 * . a "delete" button in front of already entered key/value pairs
 * @since	0.0.27
 */

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
class JFormFieldSpec extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       0.0.11
	 */
	protected $type = 'constspec';

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
		//$query->select('m.label_id as value, m.label_tr as text');
		$query->from('#__velo_const_specs as m');
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
		if ($this->element['unit']) {
			$query->where('m.unit IN ('.$this->element['unit'].')');
		}
				
		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
						JError::raiseWarning(500, $db->getErrorMsg());
		}

		return array('*' => JText::_('JOPTION_SELECT_SPEC')) + $options;
		//return $options;
	}

	protected function getInput() {
		$uri	= JFactory::getURI();
		$return = base64_encode($uri);
		$html[] = parent::getInput();
		
		if ((string) $this->element['button_add'] == 'true') {
			$html[] = "<input type='text' id='jform_spec_input_value' name='jform[spec_input_value]' class='' />";
			//$html[] = "<a href='javascript:addSpecToDiv(document.getElementById(\"jform_specs_list\").options[document.getElementById(\"jform_specs_list\").selectedIndex].value, document.getElementById(\"jform_spec_input_value\").value);'><img src='components/".JRequest::getVar('option', '0', 'get', 'string')."/images/ico-16x16/add.png' alt='".JText::_('COM_VELO_PROPOSE_SPEC')."' /></a>";
			$html[] = "<a href='javascript:addSpecToDiv(document.getElementById(\"jform_specs_list\"), document.getElementById(\"jform_spec_input_value\").value);'><img src='components/".JRequest::getVar('option', '0', 'get', 'string')."/images/ico-16x16/add.png' alt='".JText::_('COM_VELO_PROPOSE_SPEC')."' /></a>";
			$html[] = "<input type='hidden' id='jform_specs' name='jform[specs]' value='{}' />";
			$html[] = "<div id='jform_specs_div' name='jform[specs_div]'></div>";
		}
		
		return implode($html);
	}
}