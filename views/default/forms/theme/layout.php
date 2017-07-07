<?php

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('admin:theme:layout:site_menu_position'),
	'value' => elgg_get_plugin_setting('site_menu_position', 'hypeUI', 'topbar'),
	'name' => 'params[site_menu_position]',
	'options_values' => [
		'topbar' => elgg_echo('admin:theme:layout:site_menu_position:topbar'),
		'navbar' => elgg_echo('admin:theme:layout:site_menu_position:navbar'),
	],
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('admin:theme:layout:site_menu_count'),
	'#help' => elgg_echo('admin:theme:layout:site_menu_count:help'),
	'value' => elgg_get_plugin_setting('site_menu_count', 'hypeUI', 5),
	'name' => 'params[site_menu_count]',
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);