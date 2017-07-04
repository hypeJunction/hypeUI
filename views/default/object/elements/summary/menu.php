<?php

$menu = elgg_extract('menu', $vars);
if ($menu) {
	echo elgg_format_element('div', [
		'class' => 'elgg-listing-summary-menu',
	], $menu);
}