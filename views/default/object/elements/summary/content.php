<?php

/**
 * Outputs object summary content
 * @uses $vars['content'] Summary content
 */

$content = elgg_extract('content', $vars);
$media = elgg_extract('media', $vars);

if (!$content && !$media) {
	return;
}

if ($media) {
	$media = elgg_format_element('div', [
		'class' => 'elgg-listing-media-right',
	], $media);
}

if ($content) {
	$content = elgg_format_element('div', [
		'class' => 'elgg-listing-media-content',
	], $media . $content);
	$media = '';
}

?>
<div class="elgg-listing-summary-content elgg-content clearfix"><?= $media . $content ?></div>