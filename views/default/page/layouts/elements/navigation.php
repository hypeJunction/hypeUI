<?php

/**
 * Page layout navigation
 */

if (!elgg_get_plugin_setting('show_breadcrumbs', 'hypeUI', false)) {
	return;
}

$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

$extras = elgg_view_menu('extras', [
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]);
?>
<div class="elgg-layout-navigation">
    <div class="elgg-inner container">
        <div class="level">
            <div class="elgg-layout-breadcrumbs level-left">
                <div class="level-item">
                    <div class="breadcrumb">
						<?= $nav ?>
                    </div>
                </div>
            </div>
            <div class="elgg-layout-controls level-right">
                <div class="level-item">
					<?= $extras ?>
                </div>
            </div>
        </div>
    </div>
</div>