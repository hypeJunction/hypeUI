<?php

$guid = elgg_extract('guid', $vars);

elgg_register_rss_link();

elgg_entity_gatekeeper($guid, 'object', 'discussion');

$entity = get_entity($guid);

$container = $entity->getContainerEntity();

elgg_require_js('elgg/discussion');

elgg_set_page_owner_guid($container->getGUID());

elgg_group_gatekeeper();

if ($container instanceof ElggGroup) {
	$owner_url = "discussion/group/$container->guid";
} else {
	$owner_url = "discussion/owner/$container->guid";
}

elgg_push_breadcrumb($container->getDisplayName(), $owner_url);
elgg_push_breadcrumb($entity->getDisplayName());

$params = [
	'topic' => $entity,
];

$content = elgg_view_entity($entity, ['full_view' => true]);

$params = [
	'content' => $content,
	'title' => $entity->getDisplayName(),
	'sidebar' => elgg_view('discussion/sidebar'),
	'filter' => '',
	'entity' => $entity,
];
$body = elgg_view_layout('content', $params);

echo elgg_view_page($entity->getDisplayName(), $body, 'default', [
	'entity' => $entity,
]);
