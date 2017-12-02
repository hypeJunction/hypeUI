<?php

$content = elgg_view('object/elements/summary/content', $vars);
$attachments = elgg_view('object/elements/summary/attachments', $vars);

$body = $content . $attachments;
if (empty($body)) {
	return;
}

echo elgg_format_element('div', [
	'class' => 'elgg-listing-summary-body',
], $body);