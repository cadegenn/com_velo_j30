<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.formv.formfield');
jimport('joomla.formv.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Custom Field class for the Joomla Framework.
 *
 * @package             Joomla.Administrator
 * @subpackage          com_adh
 * @since               0.0.11
 */
class JFormFieldVelo extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       0.0.11
	 */
	protected $type = 'velo';

	/**
	 * Method to get the field options.
	 *
	 * @return      array   The field option objects.
	 * @since       1.6
	 */	
	public function getOptions()
	{
		// get current user
		$user = JFactory::getUser();
		// Initialize variables.
		$options = array();

		$db = JFactory::getDbo();
		$query  = $db->getQuery(true);

		//$query->select('id AS value, label AS text'); // => important !! AS value pour l'id et AS text pour le texte de l'option
		/**
		 * @TODO	add "format" keyword to XML form to output specific format: for example: "%m-%Y %l" = "marque-YEAR label"
		 */
		$query->select('mv.id as value, CONCAT_WS(" - ",mv.label,mv.owner) as text, mv.composant_id');
		$query->from('#__velo_monVelo AS mv');
		//$query->where('mv.published = 1'); 
		// if we got a filter, use it
		if ($this->element['filter']) {
			switch ($this->element['filter']) {
				case 'owner' :	$query->select('mc.id AS mc_id')->from('#__velo_monComposant AS mc')->where('mv.composant_id = mc.id')->where('mc.created_by = '.$user->id);
								break;
			}
		}
		$query->order('LOWER (mv.label), LOWER (mv.owner)');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return array('*' => JText::_('JOPTION_SELECT_VELO')) + $options;
		//return $options;
	}
}