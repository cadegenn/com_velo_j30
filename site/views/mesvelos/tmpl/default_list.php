<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$article_params = JComponentHelper::getParams( 'com_content' );
$user           = $this->user; //JFactory::getUser();
$component = ($component != '' ? $component : JRequest::getVar('option', null, 'get', 'string'));
$view = ($view != '' ? $view : JRequest::getVar('view', null, 'get', 'string'));
$uri	= JFactory::getURI();
?>

<!--<h2><?php echo JText::_('COM_VELO_MES_VELOS'); ?></h2>-->
<div>
<table class='table table-hover'>
<?php foreach($this->velos as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<?php
	$canCreate      = $user->authorise('core.create',		'com_velo.'.$item->id);
	$canEdit        = $user->authorise('core.edit',			'com_velo.monvelo.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
	$canEditOwn     = $user->authorise('core.edit.own',		'com_velo.monvelo.'.$item->id) && $item->created_by == $user->id;
	$canChange      = $user->authorise('core.edit.state',	'com_velo.monvelo.'.$item->id) && $canCheckin;
	?>
	<!--<li class='velo_list_item btn-toolbar'>-->
	<tr><td>
		<!--<div class="actions fltrt btn-group pull-right">
			<!--<?php if ($canCreate) : ?><span class="btn"><?php echo JHtml::_('icon.add_component', $item, $article_params); ?></span><?php endif; ?>-->
			<!--<?php if ($canCreate) { echo JHtml::_('button.link', 'plus-sign',		'action', 'index.php?option=com_velo&view=moncomposant&velo_id='.$item->id.'&layout=edit&return='.base64_encode($uri)); } ?>
			<!--<?php if ($canEditOwn) : ?><span class="btn"><?php echo JHtml::_('icon.edit', '', 'monvelo', 'edit', $item, $article_params); ?></span><?php endif; ?>-->
			<!--<?php if ($canEditOwn) { echo JHtml::_('button.link', 'pencil',			'action', 'index.php?option='.$component.'&view=monvelo&layout=edit&id='.$item->id.'&return='.base64_encode($uri)); } ?>
			<!--<?php if ($canEditOwn) : ?><span class="btn"><?php echo JHtml::_('icon.delete', '', 'monvelo', $item, $article_params); ?></span><?php endif; ?>-->
			<!--<?php if ($canEditOwn) { echo JHtml::_('button.link', 'remove-circle',	'action', 'index.php?option='.$component.'&view=monvelo&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.supprimer&'.JUtility::getToken().'=1&return='.base64_encode($uri)); } ?>
		</div>-->
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				Action <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<!--<li><?php if ($canCreate) { echo JHtml::_('button.link', 'plus-sign',		'action', 'index.php?option=com_velo&view=moncomposant&velo_id='.$item->id.'&layout=edit&return='.base64_encode($uri)); } ?></li>
				<li><?php if ($canEditOwn) { echo JHtml::_('button.link', 'pencil',			'action', 'index.php?option='.$component.'&view=monvelo&layout=edit&id='.$item->id.'&return='.base64_encode($uri)); } ?></li>
				<li class="divider"></li>
				<li><?php if ($canEditOwn) { echo JHtml::_('button.link', 'remove-circle',	'action', 'index.php?option='.$component.'&view=monvelo&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.supprimer&'.JUtility::getToken().'=1&return='.base64_encode($uri)); } ?></li>
				-->
				<li><?php if ($canCreate) { echo JHtml::_('link', 'index.php?option=com_velo&view=moncomposant&velo_id='.$item->id.'&layout=edit&return='.base64_encode($uri), 'add component'); } ?></li>
				<li><?php if ($canEditOwn) { echo JHtml::_('link', 'index.php?option='.$component.'&view=monvelo&layout=edit&id='.$item->id.'&return='.base64_encode($uri), 'edit bike'); } ?></li>
				<li class="divider"></li>
				<li><?php if ($canEditOwn) { echo JHtml::_('link', 'index.php?option='.$component.'&view=monvelo&Itemid='.$Itemid.'&id='.$item->id.'&task='.$view.'.supprimer&'.JUtility::getToken().'=1&return='.base64_encode($uri), 'remove bike'); } ?></li>
			</ul>
		</div>
		<a class="ui_element" href='index.php?option=com_velo&view=monvelo&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>'>
			<img class="favicon" src="<?php echo JHtml::_('icon.getFavicon', $item->marque_url); ?>" alt="favicon" />
			<p>
				<?php echo $item->label; ?>
				<?php if ($item->owner): ?><small><br /><?php echo $item->owner; ?></small><?php endif; ?>
			</p>
		</a>
	</td></tr>
<?php endforeach; ?>
</table>
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


