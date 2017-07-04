<?php
/**
 * Post comment river view
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$comment = $item->getObjectEntity();
$subject = $item->getSubjectEntity();
$target = $item->getTargetEntity();

$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
));

$target_link = elgg_view('output/url', array(
	'href' => $comment->getURL(),
	'text' => $target->getDisplayName(),
	'class' => 'elgg-river-target',
));

$type = $target->getType();
$subtype = $target->getSubtype() ? $target->getSubtype() : 'default';
$key = "river:comment:$type:$subtype";
if (!elgg_language_key_exists($key)) {
	$key = "river:comment:$type:default";
}

$vars['summary'] = elgg_echo($key, array($subject_link, $target_link));

$vars['attachments'] = elgg_view_entity($comment, [
	'full_view' => true,
	'class' => 'box',
]);


echo elgg_view('river/elements/layout', $vars);
