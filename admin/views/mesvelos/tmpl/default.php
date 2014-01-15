<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$user           = JFactory::getUser();
$userId         = $user->get('id');
//$listOrder      = $this->escape($this->state->get('list.ordering'));
//$listDirn       = $this->escape($this->state->get('list.direction'));
//$saveOrder      = $listOrder == 'a.ordering';

?>
<form action="<?php echo JRoute::_('index.php?option=com_velo&view=mesvelos'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<!-- TYPE FILTER -->
			<select name="filter_type_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_TYPE');?></option>
				<?php echo JHtml::_('select.options', $this->types, 'value', 'text', $this->state->get('filter.type_id'));?>
			</select>
			<!-- MARQUE FILTER -->
			<select name="filter_marque_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_MARQUE');?></option>
				<?php echo JHtml::_('select.options', $this->marques, 'value', 'text', $this->state->get('filter.marque_id'));?>
			</select>
			<!-- COMPOSANT FILTER -->
			<select name="filter_materiau_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_MATERIAU');?></option>
				<?php echo JHtml::_('select.options', $this->materiaux, 'value', 'text', $this->state->get('filter.materiau_id'));?>
			</select>
		</div>
		<div class="filter-search fltrt">
			<!-- USER FILTER -->
			<select name="filter_author_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_AUTHOR');?></option>
				<?php echo JHtml::_('select.options', $this->authors, 'value', 'text', $this->state->get('filter.author_id'));?>
			</select>
		</div>
	</fieldset>
    <table class="adminlist">
        <thead><?php echo $this->loadTemplate('head');?></thead>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <!-- <input type="hidden" name="filter_order" value="<?php //echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php //echo $listDirn; ?>" /> -->
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
