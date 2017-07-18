<?php

$context = elgg_extract('context', $vars, elgg_get_context());

// 1.8 supported 'filter_override'
if (isset($vars['filter_override'])) {
	$vars['filter'] = $vars['filter_override'];
}

$filter = elgg_extract('filter', $vars);
if ($filter === false) {
	return;
}

$items = [];

// register the default content filters
if (!isset($vars['filter']) && elgg_is_logged_in() && $context && !elgg_get_page_owner_entity()) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
	$tabs = [
		'all' => [
			'text' => elgg_echo('all'),
			'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		],
		'mine' => [
			'text' => elgg_echo('mine'),
			'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
			'selected' => ($filter_context == 'mine'),
			'priority' => 300,
		],
		'friend' => [
			'text' => elgg_echo('friends'),
			'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		],
	];

	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		$items[] = $tab;
	}

}

if (!empty($vars['filter'])) {
	if (is_string($vars['filter'])) {
		echo $vars['filter'];
	} else if (is_array($vars['filter'])) {
		$items += $vars['filter'];
	}
}

echo elgg_view_menu('filter', [
	'items' => $items,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]);