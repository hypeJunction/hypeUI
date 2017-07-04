<?php
/**
 * Elgg group icon
 *
 * @uses $vars['entity']     The group entity
 * @uses $vars['size']       The size - tiny, small, medium or large. (medium)
 * @uses $vars['use_hover']  Display the hover menu? (true)
 * @uses $vars['use_link']   Wrap a link around image? (true)
 * @uses $vars['class']      Optional class added to the .elgg-avatar div
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class for the link
 * @uses $vars['href']       Optional override of the link href
 */

$group = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars, 'medium');

if (!($group instanceof ElggGroup)) {
	return;
}

if ($size == 'tiny') {
    $size = 'small';
}

$icon_sizes = elgg_get_icon_sizes('group');
if (!array_key_exists($size, $icon_sizes)) {
	$size = 'medium';
}

$name = htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8', false);

$class = "elgg-avatar elgg-avatar-$size";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$use_link = elgg_extract('use_link', $vars, true);

$img_class = '';
if (isset($vars['img_class'])) {
	$img_class = $vars['img_class'];
}

$icon = elgg_view('output/img', array(
	'src' => $group->getIconURL($size),
	'alt' => $name,
	'title' => $name,
	'class' => $img_class,
));

if ($use_link) {
	$link_class = elgg_extract('link_class', $vars, '');
	$url = elgg_extract('href', $vars, $group->getURL());
	$link = elgg_view('output/url', [
		'href' => $url,
		'text' => $icon,
		'is_trusted' => true,
		'class' => $link_class,
	]);
} else {
	$link = elgg_format_element('span', [], $icon);
}

echo elgg_format_element('div', [
	'class' => $class,
], $link);