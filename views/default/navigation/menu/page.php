<?php
/**
 * Page menu
 *
 * @uses $vars['menu']
 * @uses $vars['selected_item']
 * @uses $vars['class']
 * @uses $vars['name']
 * @uses $vars['show_section_headers']
 */

$headers = elgg_extract('show_section_headers', $vars, false);

$vars['name'] = 'page';

$class = 'elgg-menu elgg-menu-page';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

if (isset($vars['selected_item'])) {
	$parent = $vars['selected_item']->getParent();

	while ($parent) {
		$parent->setSelected();
		$parent = $parent->getParent();
	}
}

$menus = $vars['menu'];
$vars['menu'] = [];

$all_keys = array_keys($menus);
if (elgg_in_context('admin')) {
	$preferred_keys = ['actions', 'administer', 'configure', 'develop'];
} else {
	$preferred_keys = ['actions', 'default', 'configure', 'notifications', '1_profile', 'admin', 'danger', 'user', 'group', 'extras'];
}
$other_keys = array_diff($all_keys, $preferred_keys);

$keys = array_merge($preferred_keys, $other_keys);

foreach ($keys as $key) {
	if (!empty($menus[$key])) {
		$vars['menu'][$key] = $menus[$key];
	}
}

$view = '';
foreach ($vars['menu'] as $section => $menu_items) {
	$view .= elgg_view('navigation/menu/elements/section', [
		'items' => $menu_items,
		'class' => "$class elgg-menu-page-$section menu-list",
		'section' => $section,
		'name' => $vars['name'],
		'show_section_headers' => $headers
	]);
}

echo $view;
