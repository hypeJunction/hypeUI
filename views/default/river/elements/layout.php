<?php
/**
 * Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 */

$item = elgg_extract('item', $vars);

$header = elgg_view('river/elements/header', $vars);
$body = elgg_view('river/elements/body', $vars);
$footer = elgg_view('river/elements/footer', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-river-item',
], $header . $body . $footer);
