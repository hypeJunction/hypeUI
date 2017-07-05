<?php
/**
 * Elgg pageshell for the admin area
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

$class = elgg_extract_class($vars, ['elgg-page', 'elgg-page-default']);

$context = elgg_get_context() ? : 'index';
$class[] = "elgg-page-context-$context";

$topbar = elgg_view('page/elements/topbar', $vars);

$header = elgg_view('page/elements/header', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

$message_vars = elgg_extract('sysmessages', $vars);
$messages = elgg_view('page/elements/messages', [
	'object' => $message_vars,
]);

$foot = elgg_view('page/elements/foot', $vars);

$head_vars = elgg_extract('head', $vars, []);
$head_vars['entity'] = elgg_extract('entity', $vars);
$head = elgg_view('page/elements/head', $head_vars);

$body = elgg_format_element('div', [
	'class' => $class,
], $topbar . $messages . $header . $content . $footer);

$params = array(
	'head' => $head,
	'body' => $body . $foot,
	'body_attrs' => elgg_extract('body_attrs', $vars),
);

echo elgg_view("page/elements/html", $params);