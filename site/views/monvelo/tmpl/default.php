<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
 
// Import library dependencies
JLoader::register('VELOFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JLoader::register('VELOControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
jimport('joomla.application.component.helper'); // load component helper first

$params = JComponentHelper::getParams('com_velo');
$item = $this->item;
$lang = JFactory::getLanguage();
?>

<h1><?php echo $this->document->title; ?></h1>

<?php if ((int)$this->user->id == 0) : ?>
	<?php //echo $this->loadTemplate('none'); ?>
	<div class="alert alert-danger"><?php echo JText::_('JERROR_USERS_PROFILE_NOT_FOUND');?></div>
<?php else: ?>
	<?php echo $this->loadTemplate('details'); ?>
<?php endif; ?>

