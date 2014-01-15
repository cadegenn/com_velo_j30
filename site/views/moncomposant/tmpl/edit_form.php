<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
?>


<form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="moncomposant" name="moncomposant">
	<fieldset class="adminform">
		<?php echo $this->form->getField("id")->input; ?>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("velo_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("velo_id")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("const_composant_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("const_composant_id")->input; ?></div>
			<div class="ttd"><?php echo $this->form->getField("marque_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("marque_id")->input; ?>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("model_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("model_id")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("date_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("date_achat")->input; ?></div>
			<div class="ttd"><?php echo $this->form->getField("prix_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("prix_achat")->input; ?></div>
			<div class="ttd"><?php echo $this->form->getField("distance_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("distance_achat")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("date_vente")->label; ?></div><div class="ttd"><?php echo $this->form->getField("date_vente")->input; ?></div>
			<div class="ttd"><?php echo $this->form->getField("prix_vente")->label; ?></div><div class="ttd"><?php echo $this->form->getField("prix_vente")->input; ?></div>
			<div class="ttd"><?php echo $this->form->getField("distance_vente")->label; ?></div><div class="ttd"><?php echo $this->form->getField("distance_vente")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("published")->label; ?></div><div class="ttd"><?php echo $this->form->getField("published")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="ttd"><?php echo $this->form->getField("commentaires")->label; ?></div><div class="ttd"><?php echo $this->form->getField("commentaires")->input; ?></div>
		</div>
		<div class="tr">
			<div class="td" style="margin-top: 20px;"><small><span class="star left">*</span> : <?php echo JText::_('COM_VELO_STAR_MANDATORY_FIELD'); ?></small></div>
		</div>
		<?php if (!isset($this->item->id) || $this->item->id == 0) : ?>
			<button type="submit" class="button right"><?php echo JText::_('JBUTTON_ADD_LABEL'); ?></button>
		<?php else : ?>
			<button type="submit" class="button right"><?php echo JText::_('JACTION_EDIT'); ?></button>
		<?php endif; ?>
		<button type="button" class="button right" onclick="javascript:window.location.href=atob('<?php echo $this->return_page;?>');"><?php echo JText::_('JCANCEL'); ?></button>
		<?php echo JHtml::_('form.token'); ?>
		<input type="hidden" name="task" value="moncomposant.save" /> <?php // -> controllers/moncomposant.php : JControllerForm::save() ?>
		<input type="hidden" name="id" value="<?php echo($this->item->id); ?>" />
		<?php JFactory::getApplication()->setUserState('com_velo.edit.moncomposant.id', (int) $this->item->id); ?>
	</fieldset>
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
</form>
<div class="clr"></div>

<pre><?php //var_dump($params); ?></pre>	