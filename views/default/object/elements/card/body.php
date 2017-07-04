<?php

$header = elgg_view('object/elements/summary/header', $vars);
$content = elgg_view('object/elements/summary/body', $vars);
$footer = elgg_view('object/elements/summary/footer', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-listing-card-body card-content',
], $header . $content . $footer);
