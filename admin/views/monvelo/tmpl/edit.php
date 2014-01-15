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
      method="post" name="adminForm" id="model-form">
	<div class='width-60 fltlft'>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_VELO_VELO_DETAILS' ); ?> <small>(<?php echo $this->item->id; ?>)</small></legend>
			<div class="ttr">
				<div class="ttd"><?php echo $this->form->getField("label")->label; ?></div><div class="ttd"><?php echo $this->form->getField("label")->input; ?></div>
				<div class="ttd"><?php echo $this->form->getField("type_id")->label; ?></div><div class="ttd"><?php echo $this->form->getField("type_id")->input; ?></div>
			</div>
			<div class="ttr">
				<div class="ttd"><?php echo $this->form->getField("owner")->label; ?></div><div class="ttd"><?php echo $this->form->getField("owner")->input; ?></div>
				<div class="ttd"><?php echo $this->form->getField("bicycode")->label; ?></div><div class="ttd"><?php echo $this->form->getField("bicycode")->input; ?></div>
			</div>
			<div class="tr">
				<div class="td"><?php echo $this->form->getField("commentaires")->label; ?></div><div class="td"><?php echo $this->form->getField("commentaires")->input; ?></div>
			</div>
		</fieldset>
	</div>
	<div class='width-40 fltrt'>
		<?php echo JHtml::_('sliders.start', 'content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel', JText::_('COM_VELO_COMPOSANT_DETAILS'), 'meta-options'); ?>
				<fieldset class="panelform">
					<ul class="adminformlist">
						<li><?php echo $this->form->getLabel('created_by'); ?>
						<?php echo $this->form->getField("created_by")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('marque_id'); ?>
						<?php echo $this->form->getField("marque_id")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('model_id'); ?>
						<?php echo $this->form->getField("model_id")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('specs'); ?>
						<?php echo $this->form->getField("specs")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('date_achat'); ?>
						<?php echo $this->form->getField("date_achat")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('prix_achat'); ?>
						<?php echo $this->form->getField("prix_achat")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('distance_achat'); ?>
						<?php echo $this->form->getField("distance_achat")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('date_vente'); ?>
						<?php echo $this->form->getField("date_vente")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('prix_vente'); ?>
						<?php echo $this->form->getField("prix_vente")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('distance_vente'); ?>
						<?php echo $this->form->getField("distance_vente")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('published'); ?>
						<?php echo $this->form->getField("published")->input; ?></li>
						
						<li><?php echo $this->form->getLabel('commentaires'); ?>
						<?php echo $this->form->getField("commentaires")->input; ?></li>
						
					</ul>
				</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	
	<!-- begin ACL definition-->

	<div class="clr"></div>

	<?php //if ($this->canDo->get('core.admin')): ?>
	<?php if (JFactory::getUser()->authorise($this->option.'.core.admin')): ?>
	  <div class="width-100 fltlft">
		 <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo JHtml::_('sliders.panel', JText::_('COM_VELO_FIELDSET_RULES'), 'access-rules'); ?>
			<fieldset class="panelform">
			   <?php echo $this->form->getLabel('rules'); ?>
			   <?php echo $this->form->getInput('rules'); ?>
			</fieldset>

		 <?php echo JHtml::_('sliders.end'); ?>
	  </div>
	<?php endif; ?>
	<?php if (JFactory::getUser()->authorise($this->option.'.monvelo.core.admin')): ?>
	  <div class="width-100 fltlft">
		 <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo JHtml::_('sliders.panel', JText::_('COM_VELO_FIELDSET_RULES'), 'access-rules'); ?>
			<fieldset class="panelform">
			   <?php echo $this->form->getLabel('rules'); ?>
			   <?php echo $this->form->getInput('rules'); ?>
			</fieldset>

		 <?php echo JHtml::_('sliders.end'); ?>
	  </div>
	<?php endif; ?>

	<!-- end ACL definition-->
   
	<div>
		<input type="hidden" name="task" value="monvelo.edit" />
                <?php JFactory::getApplication()->setUserState('com_velo.edit.monvelo.id', (int) $this->item->id); ?>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<!--<pre>
    <?php //echo var_dump($this); ?>
</pre>-->