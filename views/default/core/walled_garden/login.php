<?php
/**
 * Walled garden login
 */

$title = elgg_extract('title', $vars, elgg_echo('login'));
$body = elgg_view_form('login');
echo elgg_view_module('hero', $title, $body, [
	'class' => 'hero is-white elgg-module-walled-garden',
]);
