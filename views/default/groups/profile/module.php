<?php
/**
 * Group module (also called a group widget)
 *
 * @uses $vars['title']    The title of the module
 * @uses $vars['content']  The module content
 * @uses $vars['all_link'] A link to list content
 * @uses $vars['add_link'] A link to create content
 */

$group = elgg_get_page_owner_entity();

if ($group->canWriteToContainer() && !empty($vars['add_link'])) {
	$vars['content'] .= elgg_format_element('div', [
		'class' => 'elgg-widget-more',
	], $vars['add_link']);
}

echo elgg_view_module('info', $vars['title'], $vars['content'], [
	'menu' => $vars['all_link'],
	'class' => 'elgg-module-group box',
]);
