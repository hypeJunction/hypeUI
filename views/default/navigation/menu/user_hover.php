<?php

$menus = $vars['menu'];
$vars['menu'] = [];

$all_keys = array_keys($menus);
$preferred_keys = ['action', 'danger', 'admin'];
$other_keys = array_diff($all_keys, $preferred_keys);

$keys = array_merge($preferred_keys, $other_keys);
foreach ($keys as $key) {
	if (!empty($menus[$key])) {
		$vars['menu'][$key] = $menus[$key];
	}
}

$vars['menu'] = $menus;
echo elgg_view('navigation/menu/default', $vars);