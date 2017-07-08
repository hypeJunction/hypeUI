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

if ($full && !elgg_in_context('gallery')) {

	if (elgg_is_active_plugin('hypeScraper')) {
		$vars['attachments'] = elgg_view('output/player', [
			'href' => $entity->video_url,
		]);
	} else {
		$dimensions = elgg_get_config('videolist_dimensions');
		// allow altering dimensions
		$params = [
			'entity' => $entity,
			'default_dimensions' => $dimensions,
		];
		$dimensions = elgg_trigger_plugin_hook('videolist:filter_dimensions', $entity->videotype, $params, $dimensions);

		$content = elgg_view("videolist/watch/{$entity->videotype}", [
			'entity' => $entity,
			'width' => (int)$dimensions['width'],
			'height' => (int)$dimensions['height'],
		]);

		$vars['attachments'] = elgg_format_element('div', [
			'class' => 'videolist-watch',
		], $content);
	}
} else if (elgg_in_context('gallery')) {
	if (elgg_is_active_plugin('hypeScraper')) {
		$vars['media'] = elgg_view('output/player', [
			'href' => $entity->video_url,
			'fallback' => false,
		]);
	} else {
		$vars['media'] = elgg_view_entity_icon($entity, 'large');
	}
	echo elgg_view('object/elements/card', $vars);
} else {
	if (elgg_is_active_plugin('hypeScraper')) {
		$vars['media'] = elgg_view('output/player', [
			'href' => $entity->video_url,
			'fallback' => false,
		]);
	} else {
		$vars['media'] = elgg_view_entity_icon($entity, 'medium');
	}
	echo elgg_view('object/elements/summary', $vars);
}