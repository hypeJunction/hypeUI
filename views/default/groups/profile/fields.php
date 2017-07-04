<?php

/**
 * Group profile fields
 */
$group = $vars['entity'];

if (!$group instanceof ElggGroup) {
	echo elgg_echo('groups:notfound');
	return;
}

$profile_fields = elgg_get_config('group');

$fields_result = '';

if (is_array($profile_fields) && count($profile_fields) > 0) {
	foreach ($profile_fields as $key => $valtype) {
		// do not show the name
		if ($key == 'name') {
			continue;
		}

		$value = $group->$key;
		if (is_null($value)) {
			continue;
		}

		$options = ['value' => $group->$key];
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

		$label = elgg_echo("groups:$key");
		$value = elgg_view("output/$valtype", $options);

		$fields_result .= elgg_view('output/field', [
			'label' => $label,
			'value' => $value,
			'class' => 'groups-profile-field',
		]);
	}
}

if (empty($fields_result)) {
	return;
}

$result = elgg_format_element('div', [
	'class' => 'content',
], $fields_result);

echo elgg_format_element('div', [
	'class' => 'groups-profile-fields profile-details clearfix box'
], $result);