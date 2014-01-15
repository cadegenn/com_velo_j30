<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$composant = $this->item;
?>

<h2><?php echo $composant->label; ?></h2>
<div class="velo_details">
	<?php if ($composant->velo_id > 0) : ?><p> &rArr; <?php echo $composant->velo; ?></p><?php endif; ?>
	<p><img class="favicon" src="<?php echo  $composant->marque_url; ?>/favicon.ico" alt="favicon" /> <a href="<?php echo  $composant->marque_url; ?>" target="_blank"><?php echo $composant->marque; ?></a> <br />
		<?php if ($composant->url != "") : ?><a href="<?php echo $composant->url; ?>" target="_blank"><img class="favicon" src="<?php echo JURI::base(); ?>/components/com_velo/images/ico-16x16/link.png" alt="lien" /><?php echo $composant->url; ?></a><?php endif; ?>
	</p>
	<p>	<?php echo $composant->materiau; ?>
		<?php if ($composant->poids > 0) { echo ("- ".$composant->poids.' g'); } ?></p>
	<hr />
	
	<h3><?php echo JText::_('COM_VELO_SPECS_LABEL'); ?></h3>
	<p><?php echo $composant->specs; ?></p>

	<h3><?php echo JText::_('COM_VELO_COMMENTAIRES_LABEL'); ?></h3>
	<p><?php echo $composant->commentaires; ?></p>

</div>

<div class="clr"></div>
<pre><?php //var_dump($params); ?></pre>
