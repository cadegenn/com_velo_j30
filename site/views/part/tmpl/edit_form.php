<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
?>


<form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="part" name="part">
	<fieldset class="adminform">
		<?php echo $this->form->getField("id")->input; ?>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("label")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("label")->input); ?></div>
				<div class="tth"><?php echo $this->form->getField("marque_id")->label; ?></div>
				<div class="ttd"><?php echo $this->form->getField("marque_id")->input; ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("url")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("url")->input); ?></div>
				<div class="tth"><?php echo $this->form->getField("const_composant_id")->label; ?></div>
				<div class="ttd"><?php echo $this->form->getField("const_composant_id")->input; ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("const_materiau_id")->label; ?></div>
				<div class="ttd"><?php echo $this->form->getField("const_materiau_id")->input; ?></div>
				<div class="tth"><?php echo $this->form->getField("poids")->label; ?></div>
				<div class="ttd"><?php echo $this->form->getField("poids")->input; ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("release_date")->label; ?></div>
				<div class="td"><?php echo $this->form->getField("release_date")->input; ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("specs")->label; ?></div>
				<div class="td"><?php echo $this->form->getField("specs")->input; ?></div>
			</div>
			<div class="tr">
				<div class="th"><?php echo $this->form->getField("commentaires")->label; ?></div>
				<div class="td"><?php echo $this->form->getField("commentaires")->input; ?></div>
			</div>
		<?php if ($this->id == 0) : ?>
			<button type="submit" class="button right"><?php echo JText::_('JBUTTON_ADD_LABEL'); ?></button>
		<?php else : ?>
			<button type="submit" class="button right"><?php echo JText::_('JACTION_EDIT'); ?></button>
		<?php endif; ?>
		<?php echo JHtml::_('form.token'); ?>
		<input type="hidden" name="task" value="part.save" /> <?php // -> controllers/part.php : JControllerForm::save() ?>
	</fieldset>
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
</form>
<div class="clr"></div>

<pre><?php //var_dump($params); ?></pre>	