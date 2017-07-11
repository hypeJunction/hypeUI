<?php

$entity = elgg_extract('entity', $vars);

$icon = elgg_view_entity_icon($entity, 'tiny');
$link = elgg_view('output/url', [
	'href' => $entity->getURL(),
	'text' => $entity->getDisplayName(),
	'class' => 'title is-4',
]);

$imprint = elgg_view('object/elements/imprint', $vars);
if ($imprint) {
	$imprint = elgg_format_element('div', [
		'class' => 'elgg-listing-summary-subtitle elgg-subtext',
	], $imprint);
}
$menu = elgg_extract('menu', $vars);
if (!$menu && $menu !== false) {
	$menu = elgg_view('object/elements/menu/placeholder', $vars);
}

echo elgg_view_image_block($icon, $link . $imprint, [
	'class' => elgg_extract_class($vars, ['elgg-listing-widget']),
	'image_alt' => $menu,
]);