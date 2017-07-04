<?php
/**
 * Elgg default layout
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */

$class = elgg_extract_class($vars, [
	'elgg-layout',
	'elgg-layout-default',
]);

$hero = elgg_view('page/layouts/elements/hero', $vars);
$header = elgg_view('page/layouts/elements/header', $vars);
$filter = elgg_view('page/layouts/elements/filter', $vars);
$content = elgg_view('page/layouts/elements/content', $vars);
$footer = elgg_view('page/layouts/elements/footer', $vars);

echo elgg_format_element('div', [
	'class' => $class,
], $hero  . $header . $filter . $content . $footer);