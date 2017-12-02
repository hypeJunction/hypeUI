<?php

// capture global state necessary for menus
$state = [
	'contexts' => elgg_get_context_stack(),
	'input' => elgg_get_config('input'),
	'page_owner_guid' => elgg_get_page_owner_guid(),
];

$no_results = elgg_format_element('div', [
	'class' => 'elgg-no-results',
], elgg_echo('object:menu:no_results'));

// g = guid, pog = page_owner_guid, c = contexts, m = mac
$guid = (int)get_input('g', 0, false);
$page_owner_guid = (int)get_input('pog', 0, false);
$contexts = (array)get_input('c', [], false);
$mac = get_input('m', '', false);
$input = (array)get_input('i', [], false);

// verify MAC
$data = serialize([$guid, $page_owner_guid, $contexts, $input]);

if (!elgg_build_hmac($data)->matchesToken($mac)) {
	echo $no_results;

	return;
}

$entity = get_entity($guid);
if (!$entity) {
	echo $no_results;

	return;
}

// render view using state as it was in the placeholder view
// remove 'widgets' context from the stack because many handlers sniff it and don't render items
// now that the entity menu is a dropdown, it doesn't matter
$key = array_search('widgets', $contexts);
if ($key !== false) {
	unset($contexts[$key]);
}
elgg_set_context_stack($contexts);
elgg_set_config('input', $input);
elgg_set_page_owner_guid($page_owner_guid);

$params = [
	'entity' => $entity,
	'handler' => hypeapps_ui_get_entity_handler($entity),
	'sort_by' => 'priority',
	'inline' => false,
];

$menus = elgg_view_menu('entity', $params);

if ($entity instanceof ElggUser) {
	$menus .= elgg_view_menu('user_hover', $params);
}

if (!$menus) {
	echo elgg_format_element('div', [
		'class' => 'elgg-no-results',
	], elgg_echo('object:menu:no_results'));
} else {
	echo $menus;
}

// revert global state
elgg_set_context_stack($state['contexts']);
elgg_set_config('input', $state['input']);
elgg_set_page_owner_guid($state['page_owner_guid']);
