<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

$link = elgg_view('output/url', [
	'href' => $entity->address, 'text' => elgg_get_excerpt($entity->address, 100),
]);

$vars['tagline'] = elgg_view_icon('push-pin-alt') . $link;

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} else if (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}
