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
class JFormFieldPart extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       0.0.11
	 */
	protected $type = 'part';

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

		$db = JFactory::getDbo();
		$query  = $db->getQuery(true);

		//$query->select('id AS value, label AS text'); // => important !! AS value pour l'id et AS text pour le texte de l'option
		/**
		 * @TODO	add "format" keyword to XML form to output specific format: for example: "%m-%Y %l" = "marque-YEAR label"
		 */
		$query->select('m.id as value, CONCAT_WS(" - ",ma.label,YEAR(m.release_date),m.label) as text, m.const_composant_id, m.marque_id');
		$query->from('#__velo_models AS m');
		// if we got a filter, use it
		if ($this->element['filter']) {
			if (preg_match('/^!/',$this->element['filter'])) {
				$this->element['filter'] = substr($this->element['filter'],1);
				$query->select('cc.id, cc.label_id')->leftjoin('#__velo_const_composants AS cc ON (m.const_composant_id = cc.id)')->where('LOWER(cc.label_id) != LOWER("'.(string)$this->element['filter'].'")');
			} else {
				$query->select('cc.id, cc.label_id')->leftjoin('#__velo_const_composants AS cc ON (m.const_composant_id = cc.id)')->where('LOWER(cc.label_id) = LOWER("'.(string)$this->element['filter'].'")');
			}
		}
		//$query->select('ma.label')->from('#__velo_marques AS ma')->where('ma.id = m.marque_id');
		$query->select('ma.label')->leftjoin('#__velo_marques AS ma ON (ma.id = m.marque_id)');
		$query->order('LOWER (ma.label), YEAR(m.release_date) ASC, LOWER (m.label)');

		/*
		 * APPLY FILTERS
		 */
		// Filter by author
		$user = VELOdb::getCurrentUser();
		if (is_numeric($user->id)) {
			$query->where('(m.published = 1 OR (m.published = 0 AND m.created_by = '.(int) $user->id.'))');
		} else {
			$query->where('m.published = 1'); //->where('categorie = "'.$categorie.'"');
		}
				
		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
						JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $options;
	}

	protected function getInput() {
		$uri	= JFactory::getURI();
		$return = base64_encode($uri);
		$html[] = parent::getInput();
		
		if ((string) $this->element['button_add'] == 'true') {
			$html[] = "<a href='index.php?option=".JRequest::getVar('option', '0', 'get', 'string')."&view=".$this->type."&layout=edit&return=".$return."'><img src='components/".JRequest::getVar('option', '0', 'get', 'string')."/images/ico-16x16/add.png' alt='".JText::_('COM_VELO_PROPOSE_MARQUE')."' /></a>";
		}
		
		return implode($html);
	}

}