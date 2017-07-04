<?php
/**
 * View a single page
 *
 * @package ElggPages
 */

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object');

$entity = get_entity($guid);
if (!pages_is_page($entity)) {
	forward('', '404');
}

elgg_set_page_owner_guid($entity->getContainerGUID());

elgg_group_gatekeeper();

$container = elgg_get_page_owner_entity();
if (!$container) {
	forward(REFERER);
}

$title = $entity->getDisplayName();

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "pages/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "pages/owner/$container->username");
}
pages_prepare_parent_breadcrumbs($entity);
elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, array('full_view' => true));

// can add subpage if can edit this page and write to container (such as a group)
if ($entity->canEdit() && $container->canWriteToContainer(0, 'object', 'page')) {
	$url = "pages/add/$entity->guid";
	elgg_register_menu_item('title', array(
			'name' => 'subpage',
			'href' => $url,
			'text' => elgg_echo('pages:newchild'),
			'link_class' => 'elgg-button elgg-button-action',
	));
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('pages/sidebar/navigation'),
	'entity' => $entity,
));

echo elgg_view_page($title, $body, 'default' , [
	'entity' => $entity,
]);
