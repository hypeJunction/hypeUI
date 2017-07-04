<?php

$entity = elgg_extract('entity', $vars);

$subtitle = [];
if ($entity->location) {
	$subtitle[] = elgg_view_icon('map-marker') . $entity->location;
}

if ($entity->isAdmin()) {
	$vars['badges'] = elgg_format_element('span', [
		'class' => 'tag is-primary',
	], elgg_echo('user:admin'));
}

$vars['subtitle'] = implode(' ', $subtitle);

echo elgg_view('page/components/list_item', $vars);