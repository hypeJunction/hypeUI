<?php

/**
 * Object full view
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['body']          HTML for the content body
 * @uses $vars['class']         Optional additional class for the content wrapper
 */
$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggEntity) {
	elgg_log("object/elements/full expects an ElggEntity in \$vars['entity']", 'ERROR');
	return;
}

$body = elgg_extract('body', $vars);
$vars['content'] = $body;
if (empty($body) && $body !== false) {
	$vars['content'] = elgg_view('output/longtext', [
		'value' => $entity->description,
	]);
}

$responses = elgg_extract('responses', $vars);
if (empty($responses) && $responses !== false) {
	$vars['responses'] = elgg_view_comments($entity);
}

//$vars['title'] = false;
$vars['media'] = false;
$vars['class'] = elgg_extract_class($vars, ['elgg-listing-full', 'elgg-content', 'clearfix', 'box']);

echo elgg_view('object/elements/summary', $vars);

