<?php
/**
 * Group creation river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

$vars['attachments'] = elgg_view_entity($object, [
	'full_view' => false,
	'class' => 'box',
]);

echo elgg_view('river/elements/layout', $vars);