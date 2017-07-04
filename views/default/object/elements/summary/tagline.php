<?php
/**
 * Outputs object tagline
 * @uses $vars['tagline'] tagline
 */
$tagline = elgg_extract('tagline', $vars);
if (!$tagline) {
	return;
}
?>
<div class="elgg-listing-summary-tagline subtitle is-5"><?= $tagline ?></div>