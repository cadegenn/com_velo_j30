<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Import library dependencies
JLoader::register('veloFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');

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
	$canEdit        = $user->authorise('core.edit',			'com_velo.monvelo.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	$canEditOwn     = $user->authorise('core.edit.own',		'com_velo.monvelo.'.$item->id) && $item->created_by == $userId;
	$canChange      = $user->authorise('core.edit.state',	'com_velo.monvelo.'.$item->id) && $canCheckin;
	?>
	<tr class="row<?php echo $i % 2; ?>">
        <td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
		    <a href="<?php echo JRoute::_('index.php?option=com_velo&view=monvelo&layout=edit&id=' . $item->monVeloId); ?>"><?php echo $item->label; ?></a>
		</td>
		<td>
			<?php echo $item->type; ?>
		</td>
		<td>
			<?php if ($item->photo != '') : ?><img class="fltrt img_small_preview" src=<?php echo $item->photo; ?> /><?php endif; ?>
			<?php echo $item->model; ?>
		</td>
		<td>
			<img class="favicon" src="<?php echo veloFunctions::getFavicon($item->marque_url); ?>" alt="favicon" />
			<?php echo $item->marque; ?>
		</td>
		<td>
			<?php echo $item->materiau; ?>
		</td>
		<td class="center">
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'mesvelos.', $canChange, 'cb', '', ''); ?>
		</td>
		<td class="center">
			<?php echo $this->escape($item->author_name); ?>
		</td>
		<td class="center nowrap">
			<?php echo JHtml::_('date', $item->creation_date, JText::_('DATE_FORMAT_LC4')); ?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
