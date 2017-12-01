<?php
/**
 * Members index
 */

// The URL segment after members/
$page = elgg_extract('page', $vars);

$tabs = elgg_trigger_plugin_hook('members:config', 'tabs', null, array());

foreach ($tabs as $type => $values) {
	$tabs[$type]['name'] = $type;
	$tabs[$type]['text'] = $tabs[$type]['title'];
	$tabs[$type]['href'] = $tabs[$type]['url'];
	$tabs[$type]['selected'] = ($page == $type);
}

$params = array(
	'options' => array('type' => 'user', 'full_view' => false),
);

$content = elgg_trigger_plugin_hook('members:list', $page, $params, null);
if ($content === null) {
	forward('', '404');
}

$title = elgg_echo("members:title:{$page}");

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title,
	'filter' => $tabs,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
