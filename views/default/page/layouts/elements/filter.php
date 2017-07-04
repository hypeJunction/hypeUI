<?php
/**
 * Page layout filter
 */

$filter = elgg_extract('filter', $vars);

if (!isset($filter)) {
	$filter = elgg_view_menu('filter', [
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if (!$filter) {
	return;
}

?>
<div class="elgg-layout-filter nav has-shadow">
    <div class="elgg-inner container">
        <div class="nav-left">
			<?= $filter ?>
        </div>
    </div>
</div>


