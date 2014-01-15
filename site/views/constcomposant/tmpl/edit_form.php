<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
?>


<form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="constcomposant" name="constcomposant">
	<?php echo $this->form->getField("id")->input; ?>
	<fieldset class="adminform">
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
	<?php if ($this->id == 0) : ?>
		<button type="submit" class="button right"><?php echo JText::_('JBUTTON_ADD_LABEL'); ?></button>
	<?php else : ?>
		<button type="submit" class="button right"><?php echo JText::_('JACTION_EDIT'); ?></button>
	<?php endif; ?>
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="task" value="constcomposant.save" /> <?php // -> controllers/const_composant.php : JControllerForm::save() ?>
</form>
<div class="clr"></div>

<pre><?php //var_dump($params); ?></pre>	