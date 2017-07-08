<?php

$names = [
	'topbar_logo',
	'landing_hero',
];

foreach ($names as $name) {
	$view = elgg_get_plugin_setting("asset:$name", 'hypeUI');
	echo elgg_view_field([
		'#type' => 'file',
		'#label' => elgg_echo("admin:theme:asset:$name"),
		'value' => $view && elgg_view_exists($view),
		'name' => "assets[$name]",
	]);
}

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);