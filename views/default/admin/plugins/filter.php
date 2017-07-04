<?php
/**
 * Category filter for plugins
 *
 * @uses $vars['category_options']
 */

$categories = elgg_extract('category_options', $vars);
if (empty($categories)) {
	return;
}

$list_items = '';
foreach ($categories as $key => $category) {
	if (empty($key)) {
		continue;
	}

	$key = preg_replace('/[^a-z0-9-]/i', '-', $key);
	$link = elgg_view('output/url', array(
		'text' => $category,
		'href' => '#',
		'rel' => $key,
		'class' => 'tag',
	));

	$list_items .= $link;
}

$body = elgg_format_element([
	'#tag_name' => 'div',
	'class' => 'elgg-admin-plugins-categories elgg-admin-sidebar-menu elgg-menu-hz',
	'#text' => $list_items,
]);

echo elgg_view_module('', elgg_echo('filter'), $body, [
	'id' => 'plugins-filter',
]);
