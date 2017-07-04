<?php
/**
 * Blog river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

$vars['attachments'] = elgg_view_entity($object, [
	'class' => 'box',
	'full_view' => false,
]);

echo elgg_view('river/elements/layout', $vars);
