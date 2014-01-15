<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$user           = JFactory::getUser();
$userId         = $user->get('id');
//$listOrder      = $this->escape($this->published->get('list.ordering'));
//$listDirn       = $this->escape($this->published->get('list.direction'));
//$saveOrder      = $listOrder == 'a.ordering';
?>

<?php foreach($this->items as $i => $item):
	$item->max_ordering = 0; //??
	//$ordering       = ($listOrder == 'a.ordering');
	$canCreate      = $user->authorise('core.create',		'com_velo.category.'.$item->id);
	$canEdit        = $user->authorise('core.edit',			'com_velo.materiau.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	//$canEditOwn     = $user->authorise('core.edit.own',		'com_velo.chantier.'.$item->id) && $item->created_by == $userId;
	$canChange      = $user->authorise('core.edit.state',	'com_velo.materiau.'.$item->id) && $canCheckin;
	?>
	<tr class="row<?php echo $i % 2; ?>">
        <td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
		    <a href="<?php echo JRoute::_('index.php?option=com_velo&view=materiau&layout=edit&id=' . $item->id); ?>"><?php echo $item->label_tr; ?></a> <small>(<?php echo $item->label_id; ?>)</small>
		</td>
		<td class="center">
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'materiaux.', $canChange, 'cb', '', ''); ?>
		</td>
		<td class="center">
			<?php echo $this->escape($item->author_name); ?>
		</td>
		<td class="center nowrap">
			<?php echo JHtml::_('date', $item->creation_date, JText::_('DATE_FORMAT_LC4')); ?>
		</td>
		<td class="center">
			<?php if ($item->language=='*'):?>
				<?php echo JText::alt('JALL', 'language'); ?>
			<?php else:?>
				<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
			<?php endif;?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
