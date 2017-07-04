<?php 
/**
 * Elgg widget edit settings
 *
 * @uses $vars['widget']
 * @uses $vars['show_access']
 */

$widget = $vars['widget'];
$show_access = elgg_extract('show_access', $vars, true);

$edit_view = "widgets/$widget->handler/edit";
$custom_form_section = elgg_view($edit_view, array('entity' => $widget));

$access = '';
if ($show_access) {
	echo elgg_view_field([
		'#type' => 'access',
		'#label' => elgg_echo('access'),
		'name' => 'params[access_id]',
		'value' => $widget->access_id,
	]);
}

if (!$custom_form_section && !$access) {
	return;
}

echo $custom_form_section;
echo $access;
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $widget->guid));

echo elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
	'#class' => 'elgg-foot',
]);