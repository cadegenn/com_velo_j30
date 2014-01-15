<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$user           = JFactory::getUser();
$userId         = $user->get('id');
$listOrder      = $this->escape($this->state->get('list.ordering'));
$listDirn       = $this->escape($this->state->get('list.direction'));
//$saveOrder      = $listOrder == 'a.ordering';

?>
<form action="<?php echo JRoute::_('index.php?option=com_velo&view=marques'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
		</div>
		<div class="filter-search fltrt">
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>

			<!-- USER FILTER -->
			<select name="filter_author_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_AUTHOR');?></option>
				<?php echo JHtml::_('select.options', $this->authors, 'value', 'text', $this->state->get('filter.author_id'));?>
			</select>
		</div>
	</fieldset>
    <table class="adminlist">
        <thead>
			<tr>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>			
				<th><?php echo JHtml::_('grid.sort', 'COM_VELO_LABEL_LABEL', 'LOWER(m.label)', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'COM_VELO_URL_LABEL', 'm.url', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'COM_VELO_STATUS_LABEL', 'm.published', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'JGRID_HEADING_CREATED_BY', 'author_name', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JDATE', 'm.creation_date', $listDirn, $listOrder); // grid.sort => /libraries/joomla/html/html/grid.php : sort() ?>
				</th>
				<th width="5%"><?php echo JHtml::_('grid.sort', 'COM_VELO_HEADING_ID', 'id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
