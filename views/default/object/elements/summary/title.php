<?php

/**
 * Outputs object title
 * @uses $vars['title'] Title
 */

$entity = elgg_extract('entity', $vars);
$title = elgg_extract('title', $vars);

if (!$title) {
	return;
}

$badges = elgg_view('object/elements/summary/badges', $vars);
?>
<h3 class="elgg-listing-summary-title title is-3 is-spaced"><?= $title ?><?= $badges ?></h3>