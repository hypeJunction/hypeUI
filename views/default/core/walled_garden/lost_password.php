<?php
/**
 * Walled garden lost password
 */

$title = elgg_echo('user:password:lost');
$body = elgg_view_form('user/requestnewpassword');

echo elgg_view_module('aside', $title, $body, [
	'class' => 'hero is-white',
]);