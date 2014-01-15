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

$params = JComponentHelper::getParams('com_velo');
?>
<h1><?php echo $this->document->title; ?></h1>

<?php if ((int)$this->user->id != 0) : ?>
	<?php echo $this->loadTemplate('form'); ?>
<?php else : ?>
	<?php echo $this->loadTemplate('none'); ?>
<?php endif; ?>
<pre><?php //var_dump($this->user); ?></pre>