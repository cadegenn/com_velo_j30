<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper'); // load component helper first
$article_params = JComponentHelper::getParams( 'com_content' );

?>

<?php 
/**
 * la barre d'icônes
 * 
 * 
 */
// on charge les paramètres globaux des articles pour savoir quelles icônes | textes afficher
$article_params = JComponentHelper::getParams( 'com_content' );
// si on est dans une fenêtre popup pour imprimer, on n'affiche pas la barre d'icônes
$canEdit	= 1;//	pour l'instant, seul le propriétaire du vélo a le droit d'afficher cette page.
//					$this->item->params->get('access-edit');
$useDefList = (($article_params->get('show_author')) or ($article_params->get('show_category')) or ($article_params->get('show_parent_category'))
	or ($article_params->get('show_create_date')) or ($article_params->get('show_modify_date')) or ($article_params->get('show_publish_date'))
	or ($article_params->get('show_hits')));
$articleIconsDisplay = ($canEdit ||  $article_params->get('show_print_icon') || $article_params->get('show_email_icon') || $useDefList); ?>
<div class="article-icons article-icons-display-<?php echo ($articleIconsDisplay ? "true" : "false"); ?>">
<?php if (JRequest::getVar('print', 0, 'get','int') != 1) : ?>
	<ul class="actions right">
		<?php if ($article_params->get('show_print_icon')) : ?>
			<li class="print-icon"><?php echo JHtml::_('icon.print_popup',  $this->item, $article_params); ?></li>
		<?php endif; ?>
		<?php if ($article_params->get('show_email_icon')) : ?>
			<li class="email-icon"><?php echo JHtml::_('icon.email',  $this->item, $article_params); ?></li>
		<?php endif; ?>
		<li><?php echo JHtml::_('icon.add_component',  null, $article_params); ?></li>
		<li>
		<?php //echo JHtml::_('icon.print_screen',  $this->item, $article_params); ?>
		</li>
	</ul>
<?php endif; ?>
</div>
<!--<div class="clr"></div>-->

<div>
<ul class='velo_list'>
<?php foreach($this->stock as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<li class='velo_list_item'>
		<?php echo $item->composant; ?> - <?php echo $item->marque; ?> - <a href='index.php?option=com_velo&view=moncomposant&layout=default_list&id=<?php echo $item->id; ?>&model_id=<?php echo $item->model_id; ?>&published=<?php echo $item->published; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&return=<?php echo base64_encode(JFactory::getURI()); ?>'><?php echo $item->label; ?></a> <small>(<?php echo $item->total; ?>)</small>
		<ul class="actions fltrt">
			<li><?php echo JHtml::_('icon.show_list', '', 'moncomposant', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.duplicate', '', 'moncomposant', $item, $article_params); ?></li>
		</ul>
	</li>
<?php endforeach; ?>
</ul>
</div>

<h2><?php echo JText::_('COM_VELO_WISHLIST'); ?></h2>
<div>
<ul class='velo_list'>
<?php foreach($this->wishlist as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<li class='velo_list_item'>
		<?php echo $item->composant; ?> - <?php echo $item->marque; ?> - <a href='index.php?option=com_velo&view=moncomposant&layout=default_list&id=<?php echo $item->id; ?>&model_id=<?php echo $item->model_id; ?>&published=<?php echo $item->published; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&return=<?php echo base64_encode(JFactory::getURI()); ?>'><?php echo $item->label; ?></a> <small>(<?php echo $item->total; ?>)</small>
		<ul class="actions fltrt">
			<li><?php echo JHtml::_('icon.putInStock', '', 'moncomposant', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.show_list', '', 'moncomposant', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.duplicate', '', 'moncomposant', $item, $article_params); ?></li>
		</ul>
	</li>
<?php endforeach; ?>
</ul>
</div>


