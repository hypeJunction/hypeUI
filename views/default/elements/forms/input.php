<?php

/**
 * Helper view that can be used to filter vars for all input views
 */
$input_type = elgg_extract('input_type', $vars);
unset($vars['input_type']);

$input = elgg_view("input/$input_type", $vars);

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
}

echo elgg_format_element('div', [
	'class' => 'control',
], $input);
