<?php
/**
 * View for page object
 *
 * @package ElggPages
 *
 * @uses    $vars['entity']    The page object
 * @uses    $vars['full_view'] Whether to display the full view
 * @uses    $vars['revision']  This parameter not supported by elgg_view_entity()
 */


$full = elgg_extract('full_view', $vars, false);
$entity = elgg_extract('entity', $vars, false);
$revision = elgg_extract('revision', $vars, false);

if (!$entity) {
	return true;
}

// pages used to use Public for write access
if ($entity->write_access_id == ACCESS_PUBLIC) {
	// this works because this metadata is public
	$entity->write_access_id = ACCESS_LOGGED_IN;
}

if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $entity->getAnnotations([
		'annotation_name' => 'page',
		'limit' => 1,
		'reverse_order_by' => true,
	]);
	if ($annotation) {
		$annotation = $annotation[0];
	} else {
		elgg_log("Failed to access annotation for page with GUID {$entity->guid}", 'WARNING');
		return;
	}
}

$vars['icon'] = false;
$vars['media'] = elgg_view('pages/icon', ['annotation' => $annotation, 'size' => 'small']);

$editor = get_entity($annotation->owner_guid);
$editor_link = elgg_view('output/url', [
	'href' => "pages/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
]);

$date = elgg_view_friendly_time($annotation->time_created);
$vars['byline'] = elgg_echo('pages:strapline', [$date, $editor_link]);
$vars['time'] = false;

// If we're looking at a revision, display annotation menu
if ($revision) {
	$vars['metadata'] = elgg_view_menu('annotation', [
		'annotation' => $annotation,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

$vars['content'] = function($entity, $full) use ($annotation) {
	if ($full) {
		return elgg_view('output/longtext', ['value' => $annotation->value]);
	} else {
		return elgg_get_excerpt($entity->description);
	}
};

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} elseif (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}
