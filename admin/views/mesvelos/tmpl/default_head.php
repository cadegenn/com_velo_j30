<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th>
		<?php echo JText::_('COM_VELO_LABEL_LABEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_TYPE_LABEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_PART_LABEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_MARQUE_LABEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_MATERIAU_LABEL'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_STATUS_LABEL'); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_CREATED_BY', 'a.created_by', '', ''); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'JDATE', 'a.creation_date', '', ''); ?>
	</th>
	<th>
		<?php echo JText::_('COM_VELO_HEADING_ID'); ?>
	</th>
</tr>
