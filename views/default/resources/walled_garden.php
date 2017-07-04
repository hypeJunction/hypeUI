<?php

$content = elgg_view('core/walled_garden/login');

$params = array(
	'content' => $content,
);

$body = elgg_view_layout('walled_garden', $params);
echo elgg_view_page('', $body, 'walled_garden');
