<?php
/**
 * New bookmarks river entry
 *
 * @package Bookmarks
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

if (elgg_is_active_plugin('hypeScraper')) {
	$vars['attachments'] = elgg_view('output/card', [
		'href' => $object->address,
	]);
} else {
	$link = elgg_view('output/url', [
		'href' => $object->address, 'text' => elgg_get_excerpt($object->address, 100),
	]);
	$vars['attachments'] = elgg_view_icon('push-pin-alt') . $link;
	$vars['message'] = elgg_get_excerpt($object->description);
}

echo elgg_view('river/elements/layout', $vars);
