<?php
/**
* Read a message page
*
* @package ElggMessages
*/

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'messages');

$entity = get_entity($guid);

// mark the message as read
$entity->readYet = true;

elgg_set_page_owner_guid($entity->getOwnerGUID());
$page_owner = elgg_get_page_owner_entity();

$title = $entity->title;

if ($page_owner->getGUID() == $entity->toId) {
	elgg_push_breadcrumb(elgg_echo('messages:inbox'), 'messages/inbox/' . $page_owner->username);
} else {
	elgg_push_breadcrumb(elgg_echo('messages:sent'), 'messages/sent/' . $page_owner->username);
}

elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, ['full_view' => true]);

$body = elgg_view_layout('content', [
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'entity' => $entity,
]);

echo elgg_view_page($title, $body, 'default', [
	'entity' => $entity,
]);
