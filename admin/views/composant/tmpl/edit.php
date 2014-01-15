<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

// Import library dependencies
JLoader::register('veloFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JLoader::register('veloControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');
JLoader::register('velodb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

?>

<script type="text/javascript">
	window.addEvent('domready', function() { 
		$('jform_zoomLevel').addEvent('change', function(){
			var desc = $('jform_zoomLevel_desc');
			//desc.innerHTML = "this is a test";
			//desc.innerHTML = Joomla.JText._('COM_VELO_ZOOMLEVEL_'+$('jform_zoomLevel').selectedIndex+'_DESC');
			desc.innerHTML = Joomla.JText._('COM_VELO_ZOOMLEVEL_'+$('jform_zoomLevel').value+'_DESC');
		});
		$('jform_zoomLevel_desc').innerHTML = Joomla.JText._('COM_VELO_ZOOMLEVEL_'+$('jform_zoomLevel').value+'_DESC');
	});
</script>

<form action="<?php echo JRoute::_('index.php?option=com_velo&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="composant-form">
	<div class='width-60 fltlft'>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_VELO_COMPOSANT_DETAILS' ); ?> <small>(<?php echo $this->item->id; ?>)</small></legend>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("label_id")->label; ?></div>
				<div class="td"><?php echo html_entity_decode($this->form->getField("label_id")->input); ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("label_tr")->label; ?></div>
				<div class="td"><?php echo html_entity_decode($this->form->getField("label_tr")->input); ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("language")->label; ?></div>
				<div class="td"><?php echo html_entity_decode($this->form->getField("language")->input); ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("zoomLevel")->label; ?></div>
				<div class="td"><?php echo $this->form->getField("zoomLevel")->input; ?>
					<small id="jform_zoomLevel_desc" class="instant_help"></small>
				</div>
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
		<input type="hidden" name="task" value="composant.edit" />
		<?php JFactory::getApplication()->setUserState('com_velo.edit.composant.id', (int) $this->item->id); ?>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<!--<pre>
    <?php //echo var_dump($this); ?>
</pre>-->