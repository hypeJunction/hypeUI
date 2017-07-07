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
?>
<h3 class="elgg-listing-summary-title title is-3 is-spaced"><?= $title ?></h3>