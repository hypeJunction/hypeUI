<?php

/**
 * Object summary
 * Passing an 'icon' with the variables will wrap the listing in an image block. In that case,
 * variables not listed in @uses (e.g. image_alt) will be passed to the image block.
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 * @uses $vars['icon']      Object icon. If set, the listing will be wrapped with an image block
 * @uses $vars['class']     Class selector for the image block
 * @uses $vars['media']     Media object to display with the content
 * @uses $vars['menu']      Actions menus
 * @uses $vars['image_block_vars'] Attributes for the image block wrapper
 */
$entity = elgg_extract('entity', $vars);
$full_view = elgg_extract('full_view', $vars);
if (!$entity instanceof ElggEntity) {
	elgg_log("object/elements/summary expects an ElggEntity in \$vars['entity']", 'ERROR');

	return;
}

foreach ($vars as $key => $value) {
	if (is_callable($value)) {
		$vars[$key] = call_user_func($value, $entity, $full_view);
	}
}

if ($entity instanceof ElggObject) {
	$owner = $entity->getOwnerEntity();
	if ($entity->owner_guid && !$owner) {
		elgg_log("User {$entity->owner_guid} could not be loaded, and is needed to display entity {$entity->guid}", 'WARNING');

		return;
	}

	$container = $entity->getContainerEntity();
	if ($entity->container_guid && !$container) {
		elgg_log("Entity {$entity->container_guid} could not be loaded, and is needed to display entity {$entity->guid}", 'WARNING');

		return;
	}
}

$title = elgg_extract('title', $vars);
if (empty($title) && $title !== false && $entity instanceof ElggEntity) {
	if (elgg_is_active_plugin('search') && get_input('query')) {
		if ($entity->getVolatileData('search_matched_title')) {
			$title = $entity->getVolatileData('search_matched_title');
		} else {
			$title = search_get_highlighted_relevant_substrings($entity->getDisplayName(), get_input('query'), 5, 5000);
		}
	} else {
		$title = elgg_get_excerpt($entity->getDisplayName(), 100);
	}

	$vars['title'] = elgg_view('output/url', [
		'text' => $title,
		'href' => $entity->getURL(),
	]);
}

$subtitle = elgg_extract('subtitle', $vars);
if (empty($subtitle) && $subtitle !== false && $entity instanceof ElggObject) {
	$vars['subtitle'] = elgg_view('object/elements/imprint', $vars);
}

$content = elgg_extract('content', $vars);
if (empty($content) && $content !== false && $entity) {
	foreach (['briefdescription', 'description'] as $prop) {
		if ($entity->$prop) {
			$description = elgg_get_excerpt($entity->$prop, elgg_extract('content_limit', $vars, 1000));
			if (elgg_is_active_plugin('search') && get_input('query')) {
				if ($entity->getVolatileData('search_matched_description')) {
					$description = $entity->getVolatileData('search_matched_description');
				} else {
					$description = search_get_highlighted_relevant_substrings($description, get_input('query'), 5, 5000);
				}
			}
			$vars['content'] = $description;
		}
	}
}

$tags = elgg_extract('tags', $vars);
if (empty($tags) && $tags !== false) {
	$vars['tags'] = elgg_view('output/tags', [
		'entity' => $entity,
	]);
}

$menu = elgg_extract('metadata', $vars);

$vars['menu'] = $menu;
unset($vars['metadata']);
if (empty($menu) && $menu !== false && $entity instanceof ElggEntity && elgg_is_logged_in()) {
	$vars['menu'] = elgg_view('object/elements/menu/placeholder', $vars);
}

$social = elgg_extract('social', $vars);
if (empty($social) && $social !== false && $entity instanceof ElggEntity && elgg_is_logged_in()) {
	$vars['social'] = elgg_view_menu('entity_social', [
		'entity' => $entity,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

$media = elgg_extract('media', $vars);
$icon = elgg_extract('icon', $vars);

if (empty($icon) && $icon !== false && $entity instanceof ElggEntity) {
	if ($entity instanceof ElggUser || $entity instanceof ElggGroup) {
		$vars['icon'] = elgg_view_entity_icon($entity, 'small');
	} else {
		if ($owner) {
			$vars['icon'] = elgg_view_entity_icon($owner, 'small');
		}
		if (empty($media) && $media !== false) {
			if ($entity->hasIcon('small')) {
				$size = $entity instanceof ElggFile ? 'small' : 'medium';
				$vars['media'] = elgg_view_entity_icon($entity, $size);
			}
		}
	}
}

$header = elgg_view('object/elements/summary/header', $vars);
$body = elgg_view('object/elements/summary/body', $vars);
$footer = elgg_view('object/elements/summary/footer', $vars);

echo elgg_format_element('div', [
	'class' => elgg_extract_class($vars, 'elgg-listing-summary'),
	'data-guid' => $entity->guid,
], $header . $body . $footer);
