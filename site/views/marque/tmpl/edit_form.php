<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
?>


<form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="marque" name="marque">
	<fieldset class="adminform">
		<?php echo $this->form->getField("id")->input; ?>
		<div class="tr">
			<div class="th"><?php echo $this->form->getField("label")->label; ?></div>
			<div class="td"><?php echo html_entity_decode($this->form->getField("label")->input); ?></div>
		</div>
		<div class="tr">
			<div class="th"><?php echo $this->form->getField("logo")->label; ?></div>
			<div class="td"><?php echo $this->form->getField("logo")->input; ?></div>
		</div>
		<!--<div class="tr">
			<div class="th"><?php echo $this->form->getField("favicon")->label; ?></div>
			<div class="td"><?php echo $this->form->getField("favicon")->input; ?></div>
		</div>-->
		<div class="tr">
			<div class="th"><?php echo $this->form->getField("url")->label; ?></div>
			<div class="td"><?php echo html_entity_decode($this->form->getField("url")->input); ?></div>
		</div>
		<?php if ($this->id == 0) : ?>
			<button type="submit" class="button right"><?php echo JText::_('JBUTTON_ADD_LABEL'); ?></button>
		<?php else : ?>
			<button type="submit" class="button right"><?php echo JText::_('JACTION_EDIT'); ?></button>
		<?php endif; ?>
		<?php echo JHtml::_('form.token'); ?>
		<input type="hidden" name="task" value="marque.save" /> <?php // -> controllers/marque.php : JControllerForm::save() ?>
	</fieldset>
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
</form>
<div class="clr"></div>

<pre><?php //var_dump($params); ?></pre>	