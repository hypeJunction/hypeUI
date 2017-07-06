<?php

if (empty($vars['menu']['default'])) {
	return;
}

foreach ($vars['menu']['default'] as $item) {
	echo elgg_view('navigation/menu/filter/item', [
		'item' => $item,
		'link_class' => 'nav-item is-tab',
	]);
}