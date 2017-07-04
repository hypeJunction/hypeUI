<?php

$item = elgg_extract('item', $vars);

$timestamp = elgg_view_friendly_time($item->getTimePosted());

echo elgg_format_element('span', [
	'class' => 'elgg-river-timestamp',
], elgg_view_icon('history') . $timestamp);