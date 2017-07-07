<?php

$site = elgg_get_site_entity();

if (elgg_in_context('admin')) {
	$logo = elgg_view('output/url', [
		'text' => elgg_echo('admin'),
		'href' => 'admin',
		'class' => 'title is-4',
	]);
} else {
	$text = $site->url;

	$view = elgg_get_plugin_setting('asset:topbar_logo', 'hypeUI');
	if ($view && elgg_view_exists($view)) {
		$text = elgg_view('output/img', [
			'src' => elgg_get_simplecache_url($view),
			'alt' => $site->name,
		]);
	} else if (elgg_view_exists('theme/topbar_logo.svg')) {
		$text = elgg_view('output/img', [
			'src' => elgg_get_simplecache_url('theme/topbar_logo.svg'),
			'alt' => $site->name,
		]);
	}

	$logo = elgg_view('output/url', [
		'text' => $text,
		'href' => $site->url,
		'class' => 'title is-4',
	]);
}

echo elgg_format_element('div', [
	'class' => 'elgg-topbar-logo nav-item',
], $logo);
