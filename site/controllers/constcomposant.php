<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Site
 * @subpackage	com_velo
 */
class veloControllerConstComposant extends JControllerForm
{
    function __construct($config = array()) {
		// le pluriel par défaut de Joomla n'est pas le bon : moncomposant => mescomposants
		$this->view_list = 'moncomposant';
		parent::__construct($config);
    }
	
}
