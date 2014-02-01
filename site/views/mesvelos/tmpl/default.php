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

jimport('joomla.application.component.helper'); // load component helper first
$article_params = JComponentHelper::getParams( 'com_content' );
$user           = $this->user; //JFactory::getUser();
?>

<?php 
/**
 * la barre d'icônes
 * 
 * 
 */
// on charge les paramètres globaux des articles pour savoir quelles icônes | textes afficher
//$article_params = JComponentHelper::getParams( 'com_content' );
// si on est dans une fenêtre popup pour imprimer, on n'affiche pas la barre d'icônes
$canCreate      = 1; //$user->authorise('core.create',		'com_velo.'.$item->id);
$canEdit	= 1;//	pour l'instant, seul le propriétaire du vélo a le droit d'afficher cette page.
//					$this->item->params->get('access-edit');
$useDefList = (($article_params->get('show_author')) or ($article_params->get('show_category')) or ($article_params->get('show_parent_category'))
	or ($article_params->get('show_create_date')) or ($article_params->get('show_modify_date')) or ($article_params->get('show_publish_date'))
	or ($article_params->get('show_hits')));
$articleIconsDisplay = ($canEdit ||  $article_params->get('show_print_icon') || $article_params->get('show_email_icon') || $useDefList); ?>
<div class="hidden-xs btn-toolbar pull-right article-icons article-icons-display-<?php echo ($articleIconsDisplay ? "true" : "false"); ?>">
<?php if (JRequest::getVar('print', 0, 'get','int') != 1) : ?>
	<ul class="btn-groups actions right">
		<?php if ($article_params->get('show_print_icon')) : ?>
			<li class="btn print-icon"><?php echo JHtml::_('glyph.print_popup',  $this, $article_params); ?></li>
		<?php endif; ?>
		<?php if ($article_params->get('show_email_icon')) : ?>
			<li class="btn email-icon"><?php echo JHtml::_('glyph.email',  $this, $article_params); ?></li>
		<?php endif; ?>
			<?php if ($canCreate) : ?><li class="btn newbike-icon"><?php echo JHtml::_('glyph.new_bike',  $article_params); ?></li><?php endif; ?>
		<li>
		<?php //echo JHtml::_('icon.print_screen',  $this->item, $article_params); ?>
		</li>
	</ul>
<?php endif; ?>
</div>
<!--<div class="clr"></div>-->

<h1 class="hidden-xs"><?php echo $this->document->title; ?></h1>

	<?php //echo("<pre>");var_dump($this);echo("</pre>"); ?>
<?php
	if ($this->user->id != 0) {
		echo $this->loadTemplate('list');
	} else {
		echo $this->loadTemplate('none');
	}
?>

<pre><?php //var_dump($this->velos); ?></pre>
