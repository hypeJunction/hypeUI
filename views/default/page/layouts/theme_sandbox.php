<?php

/**
 * Theme sandbox layout
 */
$vars['sidebar'] = elgg_view_menu('theme_sandbox', [
	'sort_by' => 'name',
	'class' => 'elgg-menu-page menu-list',
		]);

echo elgg_view('page/layouts/one_sidebar', $vars);
