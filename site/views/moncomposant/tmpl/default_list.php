<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// on charge les paramètres globaux des articles pour savoir quelles icônes | textes afficher
$article_params = JComponentHelper::getParams( 'com_content' );
?>

<h2><?php echo $this->item->label; ?></h2>
<div class="velo_details">
	<p><img class="favicon" src="<?php echo  $this->item->marque_url; ?>/favicon.ico" alt="favicon" /> <?php echo $this->item->marque; ?></p>
</div>

<!--<div class="clr"></div>-->

<div>
<ul class='velo_list'>
<?php foreach($this->items as $i => $item) : ?>
	<?php //echo("<pre>");var_dump($item); echo("</pre>"); ?>
	<li class='velo_list_item'>
		<?php echo $item->composant; ?> - <?php echo $item->marque; ?> - <a href='index.php?option=com_velo&view=moncomposant&id=<?php echo $item->id; ?>&Itemid=<?php echo JRequest::getVar('Itemid', 0, 'get','int'); ?>&return=<?php echo base64_encode(JFactory::getURI()); ?>'><?php echo $item->label; ?></a>
		<?php if ($item->velo_id > 0) : ?><small> &rArr; <?php echo $item->velo; ?></small><?php endif; ?>
		<ul class="actions fltrt">
			<li><?php echo JHtml::_('icon.edit', '', 'moncomposant', 'edit', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.duplicate', '', 'moncomposant', $item, $article_params); ?></li>
			<li><?php echo JHtml::_('icon.delete', '', 'moncomposant', $item, $article_params); ?></li>
		</ul>
	</li>
<?php endforeach; ?>
</ul>
</div>

<pre><?php //var_dump($this->items); ?></pre>	