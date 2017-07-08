<?php
/**
 * Videolist item river view.
 */

$object = $vars['item']->getObjectEntity();

if (elgg_is_active_plugin('hypeScraper')) {
	$vars['attachments'] = elgg_view('output/player', [
		'href' => $object->video_url,
	]);
} else {
	$vars['attachments'] = elgg_view_entity($object, [
		'full_view' => false,
		'class' => 'box',
	]);
}

echo elgg_view('river/elements/layout', $vars);
