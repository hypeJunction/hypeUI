<?php
/**
 * File river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

$subject = $item->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->getDisplayName(),
	'class' => 'elgg-river-subject',
));

$object_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$subject->username",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
));

$vars['summary'] = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));

$vars['attachments'] = elgg_view_entity($object, [
	'class' => 'box',
	'full_view' => false,
]);

echo elgg_view('river/elements/layout', $vars);
