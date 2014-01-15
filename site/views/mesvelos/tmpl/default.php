<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
JLoader::register('VELOdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');
JLoader::register('VELOFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$user = VELOdb::getCurrentUser();
//echo("<pre>");var_dump($user); echo("</pre>");

$template = JFactory::getApplication()->getTemplate();

?>

<h1><?php echo $this->document->title; ?></h1>
<?php //echo("<pre>");var_dump($this);echo("</pre>"); ?>
<?php
	if ($this->user->id != 0) {
		echo $this->loadTemplate('list');
	} else {
		echo $this->loadTemplate('none');
	}
?>

<pre><?php //var_dump($this->velos); ?></pre>
