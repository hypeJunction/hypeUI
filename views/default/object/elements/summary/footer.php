<?php

$metadata = elgg_view('object/elements/summary/metadata', $vars);
$responses = elgg_view('object/elements/summary/responses', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-listing-summary-footer',
], $metadata . $responses);