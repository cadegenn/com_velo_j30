<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
jimport('joomla.application.component.helper'); // load component helper first

$template = $this->baseurl."/templates/".$this->template;
$item = $this->item;
?>

<form action="<?php echo JRoute::_('index.php?option=com_velo&view=monvelo&id='.$item->id); ?>" method="post" name="adminForm" id="adminForm">
<?php 
/**
 * la barre d'icônes
 * 
 * 
 */
// on charge les paramètres globaux des articles pour savoir quelles icônes | textes afficher
$article_params = JComponentHelper::getParams( 'com_content' );
// si on est dans une fenêtre popup pour imprimer, on n'affiche pas la barre d'icônes
$canEdit	= 1;//	pour l'instant, seul le propriétaire du vélo a le droit d'afficher cette page.
//					$item->params->get('access-edit');
if (JRequest::getVar('print', 0, 'get','int') != 1) : ?>
	<ul class="btn-group actions right">
		<li class="btn zoomLevel">
			<!-- ZOOMLEVEL FILTER -->
			<select name="filter_zoomLevel" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ZOOMLEVEL');?></option>
				<?php echo JHtml::_('select.options', $this->zoomLevels, 'value', 'text', $this->state->get('filter.zoomLevel'));?>
			</select>
		</li>
		<?php if ($article_params->get('show_print_icon')) : ?>
			<li class="btn print-icon"><?php echo JHtml::_('icon.print_popup',  $item, $article_params); ?></li>
		<?php endif; ?>
		<?php if ($article_params->get('show_email_icon')) : ?>
			<li class="btn email-icon"><?php echo JHtml::_('icon.email',  $item, $article_params); ?></li>
		<?php endif; ?>
		<li><?php echo JHtml::_('icon.add_component',  $item, $article_params); ?></li>
		<?php if ($canEdit) : ?>
			<li class="btn edit-icon">
			<?php echo JHtml::_('icon.edit', '', '', 'edit', $item, $article_params); ?>
			</li>
		<?php endif; ?>
		<li>
		<?php //echo JHtml::_('icon.print_screen',  $item, $article_params); ?>
		</li>
	</ul>
<?php endif; ?>
</form>

<h2><?php echo $item->label; ?></h2>

<table class="table table-hover table-condensed">
	<tr><td>
		<?php if ($item->photo != '') : ?><img class="left img-thumbnail" src=<?php echo $item->photo; ?> /><?php endif; ?>
		<small><?php echo $item->ct_label; ?> - <?php echo $item->owner; ?></small><br />
		<b><?php echo $item->model; ?></b><br />
		<img class="favicon" src="<?php echo JHtml::_('icon.getFavicon', $item->marque_url); ?>" alt="favicon" /><?php echo $item->marque; ?><br />
		<?php if ($item->url != "") : ?><a href="<?php echo $item->url; ?>" target="_blank"><img class="favicon" src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/link.png" alt="lien" /><?php echo $item->url; ?></a><br /><?php endif; ?>
		<div id='jform_specs_div' name='jform[specs_div]'>
			<ul class='specs'>
				<!--<pre><?php var_dump($item->specs); ?></pre>-->
				<?php foreach (json_decode($item->specs,true) as $key => $value) : ?>
					<li><?php echo VELOdb::getSpecLabel($key, $lang->getTag()); ?> : <?php echo $value; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php if ($item->bicycode !="") { echo (" - ".JText::_('COM_VELO_BICYCODE_LABEL')." : ".$item->bicycode)."<br />"; } ?>
		<?php if ($item->prix_achat > 0) : ?><img src='<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/coins.png' /> <?php echo $composant->prix_achat." €"; endif; ?><br />
		<p><?php echo $item->commentaires; ?></p>
		<p class="clear"></p>
	</td></tr>
	<?php foreach ($this->composants as $composant) : ?>
		<tr><td>
			<?php // try to display category only once
			if ($prev_class != $composant->class): ?>
			<h3 class="<?php echo $composant->class; ?>"><?php echo $composant->label; ?></h3>
			<?php $prev_class = $composant->class;
			endif;?>
			<div>
				<div class="btn-group actions right">
					<!-- icône modifier -->
					<li class="btn"><?php echo JHtml::_('icon.edit', '', 'moncomposant', 'edit', $composant, $article_params); ?></li>
					<!--<a href='index.php?option=com_velo&view=moncomposant&id=<?php echo $composant->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&layout=edit'><img src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/pencil.png" alt="<?php echo JText::_('JACTION_EDIT'); ?>"/></a>-->
					<!-- icône attacher (monter sur le vélo => passer de la liste de souhait / stock sur le vélo) -->
					<li class="btn"><?php echo JHtml::_('icon.attach', '', 'moncomposant', $composant, $article_params); ?></li>
					<!-- icône détacher (mettre en stock) -->
					<li class="btn"><?php echo JHtml::_('icon.detach', '', 'moncomposant', $composant, $article_params); ?></li>
					<!-- icône supprimer -->
					<li class="btn"><?php echo JHtml::_('icon.delete', '', 'moncomposant', $composant, $article_params); ?></li>
					<!--<a href='index.php?option=com_velo&view=moncomposant&id=<?php echo $composant->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&task=moncomposant.supprimer&<?php echo JUtility::getToken(); ?>=1'><img src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/delete.png" alt="<?php echo JText::_('JACTION_DELETE'); ?>" /></a>-->
				</div>
				<div class="component_published_<?php echo $composant->published; ?>">
					<!-- détails -->
					<!--<p>	<img class="favicon" src="<?php echo  $composant->marque_url; ?>/favicon.ico" alt="favicon" /><?php echo $composant->marque; ?> - <?php echo $composant->model; ?></p>-->
					<img class="left img_medium_preview" src=<?php echo $composant->photo; ?> />
					<img class="favicon" src="<?php echo JHtml::_('icon.getFavicon', $composant->marque_url); ?>" alt="favicon" /><?php echo $composant->marque; ?> - 
					<?php if ($composant->url != "") : ?>
						<a href="<?php echo $composant->url; ?>" target="_blank"><?php echo $composant->model; ?></a>
					<?php else : ?>
						<?php echo $composant->model; ?>
					<?php endif; ?><br />
					<div id='jform_specs_div' name='jform[specs_div]'>
						<ul class='specs'>
							<!--<pre><?php var_dump($composant->specs); ?></pre>-->
							<?php
							$specs = json_decode($composant->specs,true);
							foreach ($specs as $key => $value) : ?>
								<li><?php echo VELOdb::getSpecLabel($key, $lang->getTag()); ?> : <?php echo $value; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<!--<p>	<?php if ($composant->date_achat != "0000-00-00") { echo JText::_('COM_VELO_DATE_ACHAT_LABEL')." : ".$composant->date_achat; } ?><?php if ($composant->prix_achat > 0) { echo " - ".$composant->prix_achat." €"; } ?></p>-->
					<?php if ($composant->date_achat != "0000-00-00") : ?><img src='<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/calendar.png' /> <?php echo $composant->date_achat; endif; ?><br />
					<?php if ($composant->prix_achat > 0) : ?><img src='<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/coins.png' /> <?php printf("%01.2f €",$composant->prix_achat); endif; ?>
					<!--<p class="<?php echo $composant->cm_class; ?>"><?php echo $composant->materiau; ?></p>-->
					<?php if ($composant->poids > 0) { echo ("- ".$composant->poids.' g'); } ?><br />
				</div>
			</div>
		</td></tr>
	<?php endforeach;?>
</table>

<pre><?php //var_dump($item); ?></pre>	
<pre><?php //var_dump($this->composants); ?></pre>	
