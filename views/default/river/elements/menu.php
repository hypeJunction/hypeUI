<?php

$item = elgg_extract('item', $vars);

if (isset($vars['menu'])) {
	echo $vars['menu'];
	return;
}

echo elgg_view_menu('river', [
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]);