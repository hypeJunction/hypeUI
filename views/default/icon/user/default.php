<?php
/**
 * Elgg user icon
 *
 * Rounded avatar corners - CSS3 method
 * uses avatar as background image so we can clip it with border-radius in supported browsers
 *
 * @uses $vars['entity']     The user entity. If none specified, the current user is assumed.
 * @uses $vars['size']       The size - tiny, small, medium or large. (medium)
 * @uses $vars['use_hover']  Display the hover menu? (true)
 * @uses $vars['use_link']   Wrap a link around image? (true)
 * @uses $vars['class']      Optional class added to the .elgg-avatar div
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class for the link
 * @uses $vars['href']       Optional override of the link href
 */

$user = elgg_extract('entity', $vars, elgg_get_logged_in_user_entity());
$size = elgg_extract('size', $vars, 'medium');

if (!($user instanceof ElggUser)) {
	return;
}

if ($size == 'tiny') {
	$size = 'small';
}

$icon_sizes = elgg_get_icon_sizes('user');
if (!array_key_exists($size, $icon_sizes)) {
	$size = 'medium';
}

$name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8', false);

$class = elgg_extract_class($vars, ["elgg-avatar", "elgg-avatar-$size"]);

if ($user->isBanned()) {
	$class[] = 'elgg-state-banned';
	$banned_text = elgg_echo('banned');
	$name .= " ($banned_text)";
}

$tooltip = elgg_extract('tooltip', $vars, true);
if ($tooltip) {
	$class[] = 'elgg-tooltip';
}

$use_link = elgg_extract('use_link', $vars, true);

$img_class = '';
if (isset($vars['img_class'])) {
	$img_class = $vars['img_class'];
}

$icon = elgg_view('output/img', [
	'src' => $user->getIconURL($size),
	'alt' => $name,
	'title' => $name,
	'class' => $img_class,
]);

if ($use_link) {
	$link_class = elgg_extract('link_class', $vars, '');
	$url = elgg_extract('href', $vars, $user->getURL());
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
	'title' => $name,
], $link);