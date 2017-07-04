<?php
/**
 * Update profile river view
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

$vars['summary'] = elgg_echo('river:update:user:profile', array($subject_link));

echo elgg_view('river/elements/layout', $vars);
