<?php
/**
 * Profile widgets/tools
 *
 * @package ElggGroups
 */

$views = _elgg_services()->views->getViewList('groups/tool_latest');

$col1 = [];
$col2 = [];
$i = 0;
foreach ($views as $view) {
	if ($view == 'groups/tool_latest') {
		continue;
	}

	$output = elgg_view($view, $vars);
	if ($output) {
		$i++;
		if ($i % 2 == 1) {
			$col1[] = $output;
		} else {
			$col2[] = $output;
		}
	}
}

?>

<?= elgg_view('groups/sidebar/members', $vars) ?>

<div class="groups-tools columns">
    <div class="column is-half">
		<?= implode('', $col1) ?>
    </div>
    <div class="column is-half">
		<?= implode('', $col2) ?>
    </div>
</div>