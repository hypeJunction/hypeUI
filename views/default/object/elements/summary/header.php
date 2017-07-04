<?php

$icon = elgg_extract('icon', $vars);

$title = elgg_view('object/elements/summary/title', $vars);
$tagline = elgg_view('object/elements/summary/tagline', $vars);
$menu = elgg_view('object/elements/summary/menu', $vars);
$subtitle = elgg_view('object/elements/summary/subtitle', $vars);
$inline_content = elgg_view('object/elements/summary/inline_content', $vars);
$extensions = elgg_view('object/summary/extend', $vars);

$params = (array)elgg_extract('image_block_vars', $vars, []);
$class = elgg_extract_class($params, ['elgg-listing-summary-header']);
$params['class'] = $class;

echo elgg_view_image_block($icon, $menu . $title . $tagline . $subtitle . $extensions . $inline_content, $params);