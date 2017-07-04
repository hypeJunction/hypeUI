<?php
/**
 * Second layout sidebar_alt
 */
$sidebar_alt = elgg_extract('sidebar_alt', $vars);
if ($sidebar_alt === false) {
	return;
}
$sidebar_alt = elgg_view('page/elements/sidebar_alt', $vars);
if (!$sidebar_alt) {
	return;
}
?>
<div class="elgg-layout-sidebar-alt elgg-sidebar-alt column is-2">
	<div class="elgg-inner">
		<?= $sidebar_alt ?>
	</div>
</div>
