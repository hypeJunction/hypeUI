<?php
/**
 * Videolist item renderer.
 *
 * @package ElggVideolist
 */

$full = elgg_extract('full_view', $vars, false);
$entity = elgg_extract('entity', $vars, false);
/* @var ElggObject $entity */

if (!$entity) {
	return true;
}

$vars['media'] = elgg_view_entity_icon($entity, 'medium');

if ($full && !elgg_in_context('gallery')) {

	$dimensions = elgg_get_config('videolist_dimensions');
	// allow altering dimensions
	$params = array(
		'entity' => $entity,
		'default_dimensions' => $dimensions,
	);
	$dimensions = elgg_trigger_plugin_hook('videolist:filter_dimensions', $entity->videotype, $params, $dimensions);

	$content = elgg_view("videolist/watch/{$entity->videotype}", array(
		'entity' => $entity,
		'width' => (int) $dimensions['width'],
		'height' => (int) $dimensions['height'],
	));
	$vars['attachments'] = "<div class=\"videolist-watch\">$content</div>";
} elseif (elgg_in_context('gallery')) {
	$vars['class'] = 'videolist-gallery-item';
} else {
	echo elgg_view('object/elements/summary', $vars);
}