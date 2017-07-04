<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */


echo elgg_view('profile/wrapper');

echo elgg_view_layout('widgets', [
	'num_columns' => 2,
]);
