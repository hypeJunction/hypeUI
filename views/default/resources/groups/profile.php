<?php

$guid = elgg_extract('guid', $vars);

elgg_register_rss_link();

elgg_entity_gatekeeper($guid, 'group');

$entity = get_entity($guid);

elgg_push_breadcrumb($entity->getDisplayName());

groups_register_profile_buttons($entity);

$content = elgg_view('groups/profile/layout', array('entity' => $entity));
$sidebar = elgg_view('groups/sidebar', ['entity' => $entity]);

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $entity->getDisplayName(),
	'entity' => $entity,
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($entity->getDisplayName(), $body, 'default', [
	'entity' => $entity,
]);