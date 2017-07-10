<?php
$content = elgg_extract('content', $vars);
if ($content === false) {
    return;
}
?>
<div class="elgg-layout-content">
    <div class="elgg-inner container">
        <?= elgg_view('page/layouts/elements/navigation', $vars) ?>
        <div class="elgg-layout-columns columns">
			<?php
			echo elgg_view('page/layouts/elements/sidebar_alt', $vars);
			echo elgg_view('page/layouts/elements/main', $vars);
			echo elgg_view('page/layouts/elements/sidebar', $vars);
			?>
        </div>
    </div>
</div>