<?php

$responses = elgg_extract('responses', $vars);

// allow river views to override the response content
$responses = elgg_extract('responses', $vars);
if ($responses === ' ') {
	// core hacks
	$responses = false;
}

if (empty($responses) && $responses !== false) {
	$responses = elgg_view('river/elements/comments', $vars);
}

if (!$responses) {
	return;
}

?>
<div class="elgg-river-responses"><?= $responses ?></div>
