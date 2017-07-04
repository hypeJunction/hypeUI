<?php

$media = elgg_extract('media', $vars);
if ($media) {
	echo elgg_format_element('div', [
	        'class' => 'elgg-listing-card-media card-image',
    ], $media);
}