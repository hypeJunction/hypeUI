<?php

$content = elgg_view('object/elements/summary/content', $vars);
$attachments = elgg_view('object/elements/summary/attachments', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-listing-summary-body',
], $content . $attachments);