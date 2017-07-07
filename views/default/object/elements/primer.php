<?php

$entity = elgg_extract('entity', $vars);

$icon = elgg_view_entity_icon($entity, 'tiny');
$link = elgg_view('output/url', [
	'href' => $entity->getURL(),
	'text' => $entity->getDisplayName(),
	'class' => 'title is-4',
]);
$menu = elgg_view('object/elements/menu/placeholder', $vars);

echo elgg_view_image_block($icon, $link, [
	'class' => elgg_extract_class($vars, ['elgg-listing-primer', 'is-vcentered']),
	'image_alt' => $menu,
]);