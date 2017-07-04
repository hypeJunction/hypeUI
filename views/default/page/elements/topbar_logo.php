<?php

$site = elgg_get_site_entity();

if (elgg_in_context('admin')) {
	$logo = elgg_view('output/url', [
		'text' => elgg_echo('admin'),
		'href' => 'admin',
		'class' => 'title is-4',
	]);
} else {
	$logo = elgg_view('output/url', [
		'text' => $site->name,
		'href' => $site->url,
		'class' => 'title is-4',
	]);
}

echo elgg_format_element('div', [
	'class' => 'elgg-topbar-logo nav-item',
], $logo);
