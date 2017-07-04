<?php

$item = elgg_extract('item', $vars);

$menu = elgg_view('river/elements/menu', $vars);
$summary = elgg_view('river/elements/summary', $vars);
$image = elgg_view('river/elements/image', $vars);

echo elgg_view_image_block($image, $menu . $summary, [
	'class' => 'elgg-river-item-header is-vcentered',
]);