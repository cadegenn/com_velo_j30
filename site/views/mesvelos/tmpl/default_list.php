<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper'); // load component helper first
$article_params = JComponentHelper::getParams( 'com_content' );
$user           = JFactory::getUser();
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
$canCreate      = $user->authorise('core.create',		'com_velo.'.$item->id);
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
			<li class="print-icon"><?php echo JHtml::_('icon.print_popup',  $this, $article_params); ?></li>
		<?php endif; ?>
		<?php if ($article_params->get('show_email_icon')) : ?>
			<li class="email-icon"><?php echo JHtml::_('icon.email',  $this, $article_params); ?></li>
		<?php endif; ?>
			<?php if ($canCreate) : ?><li class="newbike-icon"><?php echo JHtml::_('icon.new_bike',  $article_params); ?></li><?php endif; ?>
		<li>
		<?php //echo JHtml::_('icon.print_screen',  $this->item, $article_params); ?>
		</li>
	</ul>
<?php endif; ?>
</div>
<!--<div class="clr"></div>-->

<!--<h2><?php echo JText::_('COM_VELO_MES_VELOS'); ?></h2>-->
<div>
<ul class='velo_list'>
<?php foreach($this->velos as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<?php
	$canCreate      = $user->authorise('core.create',		'com_velo.'.$item->id);
	$canEdit        = $user->authorise('core.edit',			'com_velo.monvelo.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
	$canEditOwn     = $user->authorise('core.edit.own',		'com_velo.monvelo.'.$item->id) && $item->created_by == $user->id;
	$canChange      = $user->authorise('core.edit.state',	'com_velo.monvelo.'.$item->id) && $canCheckin;
	?>
	<li class='velo_list_item'>
		<img class="favicon" src="<?php echo JHtml::_('icon.getFavicon', $item->marque_url); ?>" alt="favicon" />
		<a href='index.php?option=com_velo&view=monvelo&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>'><?php echo $item->label; ?></a>
		<?php echo $item->marque; ?> - <?php echo $item->owner; ?> 
		<ul class="actions fltrt">
			<!--<li><a class="right"	href='index.php?option=com_velo&view=moncomposant&id=0&velo_id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&layout=edit'>	<img src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/add.png" alt="<?php echo JText::_('COM_VELO_ADD_COMPONENT'); ?>" /></a></li>-->
			<?php if ($canCreate) : ?><li><?php echo JHtml::_('icon.add_component', $item, $article_params); ?></li><?php endif; ?>
			<!--<li><a href='index.php?option=com_velo&view=monvelo&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&layout=edit'>				<img src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/pencil.png" alt="<?php echo JText::_('JACTION_EDIT'); ?>" /></a></li>-->
			<?php if ($canEditOwn) : ?><li><?php echo JHtml::_('icon.edit', '', 'monvelo', 'edit', $item, $article_params); ?></li><?php endif; ?>
			<!--<li><a href='index.php?option=com_velo&view=monvelo&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&task=monvelo.supprimer&<?php echo JUtility::getToken(); ?>=1'>	<img src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/delete.png" alt="<?php echo JText::_('JACTION_DELETE'); ?>" /></a></li>-->
			<?php if ($canEditOwn) : ?><li><?php echo JHtml::_('icon.delete', '', 'monvelo', $item, $article_params); ?></li><?php endif; ?>
		</ul>
	</li>
<?php endforeach; ?>
</ul>
</div>

<!--<h2><?php echo JText::_('COM_VELO_MON_STOCK'); ?></h2>
<div>
<ul class='velo_list'>
<?php foreach($this->stock as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<li class='velo_list_item'>
		<?php echo $item->composant; ?> - <?php echo $item->marque; ?> - <a href='index.php?option=com_velo&view=moncomposant&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>'><?php echo $item->label; ?></a>
		<ul class="actions fltrt">
			<li><?php echo JHtml::_('icon.edit', '', 'moncomposant', 'edit', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.delete', '', 'moncomposant', $item, $article_params); ?></li>
		</ul>
	</li>
<?php endforeach; ?>
</ul>
</div>-->


