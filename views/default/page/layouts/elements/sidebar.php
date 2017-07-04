<?php
/**
 * Layout sidebar
 */
$sidebar = elgg_extract('sidebar', $vars);
if ($sidebar === false) {
	return;
}
$sidebar = elgg_view('page/elements/sidebar', $vars);
if (!$sidebar) {
	return;
}
?>
<div class="elgg-layout-sidebar elgg-sidebar column is-3">
	<div class="elgg-inner">
		<?= $sidebar ?>
	</div>
</div>
