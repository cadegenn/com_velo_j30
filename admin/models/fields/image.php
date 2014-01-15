<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
 
/**
 * Custom Field class for the Joomla Framework.
 *
 * @package             Joomla.Administrator
 * @subpackage          com_velo
 * @since               0.0.24
 */
class JFormFieldImage extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since       0.0.24
	 */
	protected $type = 'image';

	protected function getInput() {
		$uri	= JFactory::getURI();
		$return = base64_encode($uri);
		$html[] = "";
		
		// Initialize some field attributes.
		$width = (string) $this->element['width'];
		$height = (string) $this->element['height'];
		$classes = (string) $this->element['class'];
		$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		$html[] = "<img id='".$this->id."_img' ".($classes ? "class='".$classes."'" : "")." src='".$this->value."' style='".($width ? "max-width: ".$width.";" : "")." ".($height ? "max-height: ".$height.";" : "")."' />";
		$html[] = "<input type='hidden' id='".$this->id."' name='".$this->name."' value='".$this->value."' />";
		
		return implode($html);
	}

}