<?php
/**
 * River view for new discussion topics
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

$vars['responses'] = elgg_view('river/elements/discussion_replies', array('topic' => $object));

$vars['attachments'] = elgg_view_entity($object, [
	'class' => 'box',
	'full_view' => false,
]);

echo elgg_view('river/elements/layout', $vars);

