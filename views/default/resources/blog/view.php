<?php

$page_type = elgg_extract('page_type', $vars);
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'blog');
elgg_group_gatekeeper();

$entity = get_entity($guid);

elgg_set_page_owner_guid($entity->container_guid);

// no header or tabs for viewing an individual blog
$params = [
	'filter' => '',
	'title' => $entity->getDisplayName(),
];

$container = $entity->getContainerEntity();
if ($container instanceof ElggUser) {
	elgg_push_breadcrumb($container->getDisplayName(), "blog/owner/$container->username");
} else if ($contianer instanceof ElggGroup) {
	elgg_push_breadcrumb($container->getDisplayName(), "blog/group/$container->guid/all");
}

elgg_push_breadcrumb($entity->getDisplayName());

$params['entity'] = $entity;
$params['content'] = elgg_view_entity($entity, array('full_view' => true));
$params['sidebar'] = elgg_view('blog/sidebar', array('page' => $page_type));

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body, 'default', [
	'entity' => $entity,
]);
