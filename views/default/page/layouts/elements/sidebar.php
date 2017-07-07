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

$width = elgg_get_plugin_setting('sidebar_width', 'hypeUI', 3);
?>
<div class="elgg-layout-sidebar elgg-sidebar column is-<?= $width ?>">
	<div class="elgg-inner">
		<?= $sidebar ?>
	</div>
</div>
