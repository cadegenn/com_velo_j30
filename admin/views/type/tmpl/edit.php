<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

// Import library dependencies
JLoader::register('veloFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JLoader::register('veloControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');
JLoader::register('velodb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

?>

<form action="<?php echo JRoute::_('index.php?option=com_velo&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="type-form">
	<div class='width-60 fltlft'>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_VELO_TYPE_DETAILS' ); ?> <small>(<?php echo $this->item->id; ?>)</small></legend>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("label_id")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("label_id")->input); ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("label_tr")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("label_tr")->input); ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("language")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("language")->input); ?></div>
			</div>
		</fieldset>
	</div>
	<div class='width-40 fltrt'>
		<?php echo JHtml::_('sliders.start', 'content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel', JText::_('COM_VELO_FIELDSET_PUBLISHING'), 'meta-options'); ?>
				<fieldset class="panelform">
					<ul class="adminformlist">
						<li><?php echo $this->form->getLabel('published'); ?>
						<?php echo $this->form->getInput('published'); ?></li>
						
						<li><?php echo $this->form->getLabel('created_by'); ?>
						<?php echo $this->form->getInput('created_by'); ?></li>
						
						<li><?php echo $this->form->getLabel('creation_date'); ?>
						<?php echo $this->form->getInput('creation_date'); ?></li>
						
						<li><?php echo $this->form->getLabel('modified_by'); ?>
						<?php echo $this->form->getInput('modified_by'); ?></li>
						
						<li><?php echo $this->form->getLabel('modification_date'); ?>
						<?php echo $this->form->getInput('modification_date'); ?></li>
					</ul>
				</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	<div>
		<input type="hidden" name="task" value="type.edit" />
                <?php JFactory::getApplication()->setUserState('com_velo.edit.type.id', (int) $this->item->id); ?>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<!--<pre>
    <?php //echo var_dump($this); ?>
</pre>-->