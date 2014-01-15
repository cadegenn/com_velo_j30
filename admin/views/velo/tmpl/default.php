<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

<table style="width: 100%;">
	<thead>	<th style="width: 33%;"><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=mesvelos'><?php echo JText::_('COM_VELO_LAST_VELOS'); ?></a></th>
			<th style="width: 33%;"><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=marques'><?php echo JText::_('COM_VELO_PENDING_MARQUES'); ?></a></th>
			<th style="width: 33%;"><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=parts'><?php echo JText::_('COM_VELO_PENDING_MODELS'); ?></a></th>
	</thead>
	<tr><td><ul>
			<?php foreach ($this->latest_velos as $i => $velo) : ?>
			<li><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=monvelo&layout=edit&id=<?php echo $velo->id; ?>'><?php echo($velo->label);?></a> <?php echo(JText::_('COM_VELO_REGISTERED_DATE_LABEL')." ".$velo->creation_date); ?></li>
			<?php endforeach; ?>
			</ul>
		</td>
		<td><ul>
			<?php foreach ($this->pending_marques as $i => $marque) : ?>
			<li><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=marque&layout=edit&id=<?php echo $marque->id; ?>'><?php echo($marque->label);?></a> <?php echo(JText::_('COM_VELO_REGISTERED_DATE_LABEL')." ".$marque->creation_date); ?> <?php if ($marque->url != '')  : ?><small><a href="<?php echo $marque->url; ?>" target="_blank">(url)</a></small><?php endif; ?></li>
			<?php endforeach; ?>
			</ul>
		</td><td><ul>
			<?php foreach ($this->pending_models as $i => $model) : ?>
			<li><a href='index.php?option=<?php echo JRequest::getVar('option', '0', 'get', 'string'); ?>&view=part&layout=edit&id=<?php echo $model->id; ?>'><?php echo($model->label);?></a> <?php echo(JText::_('COM_VELO_REGISTERED_DATE_LABEL')." ".$model->creation_date); ?> <?php if ($model->url != '')  : ?><small><a href="<?php echo $model->url; ?>" target="_blank">(url)</a></small><?php endif; ?></li>
			<?php endforeach; ?>
			</ul>
		</td>
	</tr>
</table>

<pre><?php //var_dump($this); ?></pre>