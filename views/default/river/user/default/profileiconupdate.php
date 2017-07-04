<?php
/**
 * Update avatar river view
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$subject = $item->getSubjectEntity();

$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->getDisplayName(),
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$vars['summary'] = elgg_echo('river:update:user:avatar', array($subject_link));

$vars['attachments'] = elgg_view_entity_icon($subject, 'large', [
	'class' => 'box',
]);

echo elgg_view('river/elements/layout', $vars);
