<?php
/**
 * Group join river view.
 */

$item = elgg_extract('item', $vars);
$object = $item->getObjectEntity();

$vars['attachments'] = elgg_view_entity($object, [
	'class' => 'box',
	'full_view' => false,
]);

echo elgg_view('river/elements/layout', $vars);

