<?php
/**
 * View a wire post
 *
 * @uses $vars['entity']
 */

elgg_require_js('elgg/thewire');

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

// make compatible with posts created with original Curverider plugin
$thread_id = $post->wire_thread;
if (!$thread_id) {
	$post->wire_thread = $post->guid;
}

$parent = '';
if ($entity->reply) {
	$parent = elgg_format_element('div', [
		'class' => 'thewire-parent hidden',
		'id' => "thewire-previous-{$entity->guid}",
	]);
}

$vars['responses'] = $parent;
$vars['content'] = thewire_filter($entity->description);
$vars['class'] = elgg_extract_class($vars, 'thewire-post');


echo elgg_view('object/elements/summary', $vars);



