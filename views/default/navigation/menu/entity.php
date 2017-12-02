<?php

$menu = elgg_view('navigation/menu/default', $vars);

if (elgg_extract('inline', $vars, true)) {
	$vars['menu'] = $menu;
	echo elgg_view('object/elements/menu/inline', $vars);
} else {
	echo $menu;
}