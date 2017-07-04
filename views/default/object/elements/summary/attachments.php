<?php

$attachments = elgg_extract('attachments', $vars);
if (!$attachments) {
	return;
}

echo elgg_format_element('div', [
	'class' => 'elgg-listing-summary-attachments',
], $attachments);