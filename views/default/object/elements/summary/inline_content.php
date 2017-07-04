<?php

/**
 * Outputs object summary inline content
 * @uses $vars['inline_content'] Summary inline content
 */

$inline_content = elgg_extract('inline_content', $vars);
if (!$inline_content) {
	return;
}
?>

<div class="elgg-listing-summary-inline-content"><?= $inline_content ?></div>