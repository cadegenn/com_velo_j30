<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
?>

<pre>
<?php
$user = JFactory::getUser();
/*$actions = JAccess::getActions('com_velo', 'component');
$result = new JObject;
foreach ($actions as $action) {
	$result->set($action->name, $user->authorise($action->name, 'com_velo'));
}
var_dump($result);
$result2 = new JObject;
foreach ($actions as $action) {
	$result2->set($action->name, $user->authorise($action->name, 'com_velo.monvelo'));
}
var_dump($result2);*/
?>
</pre>

	<?php if ($this->form->getField("id")->value > 0) : ?>
	<a href='index.php?option=com_velo&view=moncomposant&id=0&velo_id=<?php echo $this->form->getField("id")->value; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&layout=edit'><?php echo JText::_('COM_VELO_ADD_COMPONENT'); ?></a>
<?php endif; ?>

<form class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="monvelo" name="monvelo">
	<fieldset class="adminform">
		<?php echo $this->form->getField("id")->input; ?>
		<?php echo $this->form->getField("composant_id")->input; ?>
		<div class="ttr">
			<div class="tth"><?php echo $this->form->getField("label")->label; ?></div><div class="ttd"><?php echo $this->form->getField("label")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("type_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("type_id")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="tth"><?php echo $this->form->getField("const_composant_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("const_composant_id")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("marque_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("marque_id")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("model_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("model_id")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="tth"><?php echo $this->form->getField("owner")->label; ?></div><div class="ttd"><?php echo $this->form->getField("owner")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("bicycode")->label; ?></div><div class="ttd"><?php echo $this->form->getField("bicycode")->input; ?></div>
		</div>
                <div class="tr">
                        <div class="th"><?php echo $this->form->getField("specs")->label; ?></div>
                        <div class="td"><?php echo $this->form->getField("specs")->input; ?></div>
                </div>
		<div class="ttr">
			<div class="tth"><?php echo $this->form->getField("date_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("date_achat")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("prix_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("prix_achat")->input; ?></div>
			<div class="tth"><?php echo $this->form->getField("distance_achat")->label; ?></div><div class="ttd"><?php echo $this->form->getField("distance_achat")->input; ?></div>
		</div>
		<div class="ttr">
			<div class="tth"><?php echo $this->form->getField("published")->label; ?></div><div class="ttd"><?php echo $this->form->getField("published")->input; ?></div>
		</div>
		<div class="tr">
			<div class="th"><?php echo $this->form->getField("commentaires")->label; ?></div><div class="td"><?php echo $this->form->getField("commentaires")->input; ?></div>
		</div>
		<div class="tr" style="margin-top: 20px;">
			<div class="td"><small><span class="star left">*</span> : <?php echo JText::_('COM_VELO_STAR_MANDATORY_FIELD'); ?></small></div>
		</div>
		<div class="tr" style="margin-top: 20px;">
			<?php if (!isset($this->item->id) || $this->item->id == 0) : ?>
				<button type="submit" class="button right"><?php echo JText::_('JBUTTON_ADD_LABEL'); ?></button>
			<?php else : ?>
				<button type="submit" class="button right"><?php echo JText::_('JACTION_EDIT'); ?></button>
			<?php endif; ?>
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</fieldset>
	<input type="hidden" name="task" value="monvelo.save" /> <?php // -> controllers/monvelo.php : enregistrer() ?>
	<input type="hidden" name="id" value="<?php echo($this->item->id); ?>" />
	<?php JFactory::getApplication()->setUserState('com_velo.edit.monvelo.id', (int) $this->item->id); ?>
</form>
<div class="clr"></div>

<pre><?php //var_dump($params); ?></pre>	