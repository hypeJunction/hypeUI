<?php

$hero = elgg_view('index/hero');

if (elgg_is_logged_in()) {
	$content = elgg_view('index/logged_in');
} else {
	$content = elgg_view('index/guest');
}

$layout = elgg_view_layout('content', [
	'header' => false,
	'hero' => $hero,
	'content' => $content,
	'filter' => false,
	'sidebar' => false,
]);

echo elgg_view_page(null, $layout);