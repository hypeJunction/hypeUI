<?php

$selected = elgg_extract('selected', $vars, 'assets');

$tabs = [
	'assets',
	'layout',
];

foreach ($tabs as $tab) {
	elgg_register_menu_item('filter', [
		'name' => $tab,
		'href' => "admin/theme/$tab",
		'text' => elgg_echo("admin:theme:$tab"),
		'selected' => $selected == $tab,
	]);
}