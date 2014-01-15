<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * veloerent Controller
 */
class veloControllerMonVelo extends JControllerForm {
	function __construct($config = array()) {
		// le pluriel par défaut de Joomla n'est pas le bon : monvélo => mesvélos
		$this->view_list = 'mesvelos';
		parent::__construct($config);
    }
}
