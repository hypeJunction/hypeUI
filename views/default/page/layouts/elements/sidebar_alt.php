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

$width = elgg_get_plugin_setting('sidebar_alt_width', 'hypeUI', 3);
?>
<div class="elgg-layout-sidebar-alt elgg-sidebar-alt column is-<?= $width ?>">
	<div class="elgg-inner">
		<?= $sidebar_alt ?>
	</div>
</div>
