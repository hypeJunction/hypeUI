<?php
/**
 * Messageboard river view
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$messageboard = $item->getAnnotation();

$vars['attachments'] = elgg_view_annotation($messageboard, [
	'class' => 'box',
]);

echo elgg_view('river/elements/layout', $vars);
