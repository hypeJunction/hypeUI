<?php

/**
 * Helper view that can be used to filter vars for all input views
 */
$input_type = elgg_extract('input_type', $vars);
unset($vars['input_type']);

$input = elgg_view("input/$input_type", $vars);

$class = ['control'];

switch ($input_type) {
	case 'fieldset' :
		echo $input;
		return;

	case 'select' :
	case 'dropdown' :
	case 'access' :
		if (!elgg_extract('multiple', $vars)) {
			$input = elgg_format_element('span', ['class' => 'select'], $input);
		}
		break;

	default :
		$icon = elgg_extract('icon', $vars);
		if ($icon) {
			$class[] = 'has-icons-left';
			$input .= elgg_view_icon($icon, ['position' => 'left']);
		}

		$icon_alt = elgg_extract('icon_alt', $vars);
		if ($icon_alt) {
			$class[] = 'has-icons-right';
			$input .= elgg_view_icon($icon_alt, ['position' => 'right']);
		}
		break;
}

echo elgg_format_element('div', [
	'class' => $class,
], $input);
