<?php
/**
 * Elgg dashboard blurb
 *
 */
echo elgg_view('output/longtext', [
	'id' => 'dashboard-info',
	'class' => 'box',
	'value' => elgg_echo("dashboard:nowidgets"),
]);