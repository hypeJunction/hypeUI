<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

if (elgg_is_active_plugin('hypeScraper')) {
	$vars['attachments'] = elgg_view('output/card', [
		'href' => $entity->address,
	]);
} else {
	$link = elgg_view('output/url', [
		'href' => $entity->address, 'text' => elgg_get_excerpt($entity->address, 100),
	]);
	$vars['inline_content'] = elgg_view_icon('push-pin-alt') . $link;
}

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} else if (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}
