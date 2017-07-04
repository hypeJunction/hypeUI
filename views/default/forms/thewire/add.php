<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */

elgg_require_js('elgg/thewire');

$post = elgg_extract('post', $vars);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('reply');
}
$chars_left = elgg_echo('thewire:charleft');

if ($post) {
	echo elgg_view('input/hidden', [
		'name' => 'parent_guid',
		'value' => $post->guid,
	]);
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 2;
if ($char_limit == 0) {
	$num_lines = 3;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 3;
}

$help = elgg_format_element('div', [
	'class' => 'has-text-right',
	'id' => 'thewire-characters-remaining',
], $count_down);

echo elgg_view_field([
	'#type' => 'plaintext',
	'#help' => $help,
	'name' => 'body',
	'id' => 'thewire-textarea',
	'rows' => $num_lines,
	'data-max-length' => $char_limit,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'#id' => 'thewire-submit-button',
]);

elgg_set_form_footer($footer);
