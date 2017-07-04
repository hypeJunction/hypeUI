<?php
/**
 * Elgg profile layout
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
	'elgg-layout-profile',
]);

$header = elgg_view('page/layouts/profile/header', $vars);
$filter = elgg_view('page/layouts/profile/filter', $vars);
$content = elgg_view('page/layouts/profile/content', $vars);
$footer = elgg_view('page/layouts/profile/footer', $vars);

echo elgg_format_element('div', [
	'class' => $class,
], $navigation . $header . $filter . $content . $footer);