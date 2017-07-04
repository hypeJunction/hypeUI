<?php

$alt = elgg_extract('alt', $vars['menu'], null);
$main = elgg_extract('default', $vars['menu'], null);

$class = elgg_extract_class($vars, ['elgg-menu', 'elgg-menu-topbar', 'elgg-menu-hz']);

if ($main) {
	echo elgg_view('navigation/menu/elements/section', [
		'class' => $class,
		'item_class' => 'nav-item',
		'items' => $main,
	]);
}
if ($alt) {
	echo elgg_view('navigation/menu/elements/section', [
		'class' => $class,
		'item_class' => 'nav-item',
		'items' => $alt,
	]);
}

