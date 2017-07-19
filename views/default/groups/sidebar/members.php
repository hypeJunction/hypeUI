<?php
/**
 * Group members sidebar
 *
 * @package ElggGroups
 *
 * @uses $entity Group entity
 * @uses $vars['limit']  The number of members to display
 */

$limit = elgg_extract('limit', $vars, 14);

$entity = elgg_extract('entity', $vars);
$identifier = is_callable('group_subtypes_get_identifier') ? group_subtypes_get_identifier($entity) : 'groups';

$all_link = elgg_view('output/url', array(
	'href' => "$identifier/members/$entity->guid",
	'text' => elgg_echo('groups:members:more'),
	'is_trusted' => true,
));

$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $entity->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => $limit,
	'order_by' => 'r.time_created DESC',
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

echo elgg_view('groups/profile/module', [
	'content' => $body,
	'all_link' => $all_link,
	'title' => elgg_echo('groups:members'),
]);
