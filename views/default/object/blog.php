<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggBlog) {
	return;
}

if ($entity->status !== 'published') {
	$vars['badges'] = elgg_format_element('span', [
		'class' => 'tag is-warning',
	], elgg_echo("status:{$entity->status}"));
}

if ($entity->excerpt) {
	$vars['tagline'] = elgg_view('output/longtext', [
		'value' => $entity->excerpt,
	]);
}

if ($blog->comments_on == 'Off' || $blog->status !== 'published') {
	$params['responses'] = false;
}

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} elseif (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}
