<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

// Import library dependencies
JLoader::register('veloFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JLoader::register('veloControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');
JLoader::register('velodb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

require(JPATH_COMPONENT_ADMINISTRATOR . '/js/googleCSE-v1.php');
?>

<form action="<?php echo JRoute::_('index.php?option=com_velo&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="model-form">
	<div class='width-60 fltlft'>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_VELO_MODEL_DETAILS' ); ?> <small>(<?php echo $this->item->id; ?>)</small></legend>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("label")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("label")->input); ?></div>
				<div class="tth"><?php echo $this->form->getField("marque_id")->label; ?></div>
				<div class="ttd"><?php echo $this->form->getField("marque_id")->input; ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("url")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("url")->input); ?> <a href="<?php echo html_entity_decode($this->form->getField("url")->value); ?>" target="_blank"><img src="components/<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>/images/ico-16x16/link.png" alt="link" /></a></div>
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
		<?php echo JHtml::_('sliders.start', 'content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel', JText::_('COM_VELO_PHOTO_LABEL'), 'meta-options'); ?>
				<fieldset class="panelform">
					<?php echo $this->form->getInput('photo'); ?>
					<div class="fltlft width-60"><ul class="adminformlist">
						<li><label id="jform_cb_marque-lbl" for="jform_cb_marque"><?php echo JText::_('JSEARCH_WITH_MANUFACTURER'); ?></label>
							<div class="fltlft"><input id="jform_cb_marque" type="checkbox" /></div></li>
						<li><label id="jform_cb_model-lbl" for="jform_cb_model"><?php echo JText::_('JSEARCH_WITH_LABEL'); ?></label>
							<div class="fltlft"><input id="jform_cb_model" type="checkbox" /></div></li>
						<li><label id="jform_cb_url-lbl" for="jform_cb_model"><?php echo JText::_('JSEARCH_WITH_URL'); ?></label>
							<div class="fltlft"><input id="jform_cb_url" type="checkbox" /></div></li>
					</ul></div>
					<a class="mybutton" id="jform_image_search-btn" href='#' onclick="javascript:GAPI_image_search();">Chercher avec Google Image</a>
					<hr class="clr" />
					<div id="responseParagraph"></div>
				</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	<div>
		<input type="hidden" name="task" value="part.edit" />
        <?php JFactory::getApplication()->setUserState('com_velo.edit.part.id', (int) $this->item->id); ?>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<!--<pre>
    <?php //echo var_dump($this); ?>
</pre>-->