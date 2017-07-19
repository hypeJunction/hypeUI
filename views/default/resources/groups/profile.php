<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'group');

$entity = get_entity($guid);
elgg_set_page_owner_guid($guid);

$identifier = is_callable('group_subtypes_get_identifier') ? group_subtypes_get_identifier($entity) : 'groups';

// pushing context to make it easier to user 'menu:filter' hook
elgg_push_context("$identifier/profile");

groups_register_profile_buttons($entity);

$title = $entity->getDisplayName();

elgg_push_breadcrumb(elgg_echo($identifier), "$identifier/all");
elgg_push_breadcrumb($title);

$vars = $vars;
$vars['entity'] = $entity;

$subtype = $entity->getSubtype();
if (elgg_view_exists("profiles/group/$subtype")) {
	$content = elgg_view("profiles/group/$subtype", $vars);
} else {
	$content = elgg_view('profiles/group/default', $vars);
}
$filter = elgg_view('filters/groups/profile', $vars);
$sidebar = elgg_view('sidebars/groups/profile', $vars);

$layout_vars = array(
	'title' => $title,
	'content' => $content,
	'filter' => $filter ? : '',
	'sidebar' => $sidebar ? : null,
	'layout_name' => 'content',
);

$layout_vars = elgg_trigger_plugin_hook('layout_vars', 'groups_profile', $vars, $layout_vars);
$layout_name = elgg_extract('layout_name', $layout_vars, 'content');
unset($layout_vars['layout_name']);

$layout = elgg_view_layout($layout_name, $layout_vars);
echo elgg_view_page($title, $layout);