<?php
/**
 * Outputs object badges
 * @uses $vars['badges'] Badges
 */
$badges = elgg_extract('badges', $vars);
if (!$badges) {
	return;
}
?>
<span class="elgg-listing-summary-badges"><?= $badges ?></span>