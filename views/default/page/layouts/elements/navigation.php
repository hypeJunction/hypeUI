<?php

/**
 * Page layout navigation
 */

if (!elgg_get_plugin_setting('breadcrumbs', 'hypeUI', false)) {
	return;
}

$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
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