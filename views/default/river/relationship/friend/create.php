<?php
/**
 * Create friend river view
 */
$item = $vars['item'];
/* @var ElggRiverItem $item */

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

$subject_icon = elgg_view_entity_icon($subject, 'tiny');
$object_icon = elgg_view_entity_icon($object, 'tiny');

$vars['attachments'] = elgg_view_entity($object, [
	'full_view' => false,
	'class' => 'box',
]);

echo elgg_view('river/elements/layout', $vars);
