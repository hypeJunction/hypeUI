<?php
/**
 * View a file
 *
 * @package ElggFile
 */

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'file');

$entity = get_entity($guid);

$owner = elgg_get_page_owner_entity();

elgg_group_gatekeeper();

elgg_push_breadcrumb(elgg_echo('file'), 'file/all');

$crumbs_title = $owner->name;
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "file/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "file/owner/$owner->username");
}

$title = $entity->getDisplayName();

elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, array('full_view' => true));

$params = [
	'entity' => $entity,
];

if (elgg_trigger_plugin_hook('permissions_check:download', 'file', $params, true)) {
	elgg_register_menu_item('title', [
		'name' => 'download',
		'text' => elgg_echo('download'),
		'href' => elgg_get_download_url($entity),
		'link_class' => 'elgg-button elgg-button-action',
	]);
}

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'entity' => $entity,
));

echo elgg_view_page($title, $body, 'default', [
	'entity' => $entity,
]);
