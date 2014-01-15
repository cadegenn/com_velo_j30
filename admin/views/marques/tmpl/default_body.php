<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Import library dependencies
JLoader::register('veloFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');

$user           = JFactory::getUser();
$userId         = $user->get('id');
//$listOrder      = $this->escape($this->published->get('list.ordering'));
//$listDirn       = $this->escape($this->published->get('list.direction'));
//$saveOrder      = $listOrder == 'a.ordering';
?>

<?php foreach($this->items as $i => $item):
	$item->max_ordering = 0; //??
	//$ordering       = ($listOrder == 'a.ordering');
	$canCreate      = $user->authorise('core.create',		'com_velo.category.'.$item->id);
	$canEdit        = $user->authorise('core.edit',			'com_velo.marque.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	//$canEditOwn     = $user->authorise('core.edit.own',		'com_velo.chantier.'.$item->id) && $item->created_by == $userId;
	$canChange      = $user->authorise('core.edit.state',	'com_velo.marque.'.$item->id) && $canCheckin;
	?>
	<tr class="row<?php echo $i % 2; ?>">
        <td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php
				/*$doc = new DOMDocument();
				$doc->strictErrorChecking = FALSE;
				$doc->loadHTML(file_get_contents($item->url));
				$xml = simplexml_import_dom($doc);
				$arr = $xml->xpath('//link[@rel="shortcut icon"]');
				$favicon_url = ($arr[0]['href'] != "" ? $arr[0]['href'] : $item->url."/favicon.ico");*/
			?>
			<!--<img class="favicon" src="<?php echo  $item->url; ?>/favicon.ico" alt="favicon" />-->
			<img class="favicon" src="<?php echo veloFunctions::getFavicon($item->url); ?>" alt="favicon" />
		    <a href="<?php echo JRoute::_('index.php?option=com_velo&view=marque&layout=edit&id=' . $item->id); ?>"><?php echo $item->label; ?></a>
		</td>
		<td>
			<a href="<?php echo $item->url; ?>" target="_blank"><?php echo $item->url; ?></a>
		</td>
		<td class="center">
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'marques.', $canChange, 'cb', '', ''); ?>
		</td>
		<td class="center">
			<?php echo $this->escape($item->author_name); ?>
		</td>
		<td class="center nowrap">
			<?php echo JHtml::_('date', $item->creation_date, JText::_('DATE_FORMAT_LC4')); ?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
