<?php

if (elgg_in_context('main')) {
	$content = elgg_extract('content', $vars);
	$vars['header'] = false;
	$vars['hero'] = elgg_view('index/hero', [
		'hero_module' => $content,
	]);
	$vars['content'] = false;
}

if (!$vars['title']) {
	$vars['header'] = false;
}

echo elgg_view('page/layouts/default', $vars);
